<?php

namespace App\Http\Controllers\Customer;

use Exception;
use Carbon\Carbon;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Models\PremiumService;
use App\Models\PremiumShopping;
use App\Enums\PurchaseStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ExternalApi\Payments\Payment;
use App\Enums\AffiliateBenefitTypesEnum;
use App\Http\Requests\PremiumShoppingRequest;

class PremiumShoppingsController extends Controller
{
    public function index()
    {
        $query = PremiumShopping::query()->with('transaction')->with('purchase.purchaseStatus');

        if (request()->has('keyword') && !empty(request()->get('keyword'))) {
            $keyword = request()->get('keyword');

            $query->where(function ($q) use ($keyword) {
                foreach (PremiumShopping::fields() as $field) {
                    $q->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $rows = $query->latest()->paginate();
        return view('customer.premium_shoppings.index', compact('rows'));
    }

    public function create()
    {
        $items = PackageItem::whereRaw('package_items.amount > package_items.amount_sent')->get();
        $services = PremiumService::orderBy('name')->get();
        return view('customer.premium_shoppings.create', compact('services', 'items'));
    }

    public function store(PremiumShoppingRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $input = $request->all();

            $service = PremiumService::find($input['premium_service_id']);
            if (!empty($service->price) && $service->price > 0) {
                $input['price'] = $service->price * (int)$request->get('quantity');
                $input['status'] = 1;
            } else {
                $input['status'] = 4;
            }
            
            $courtesyService = Auth::user()
                                ->userable->affiliateCourtesyServices()
                                ->available()
                                ->ofType(AffiliateBenefitTypesEnum::COURTESY_SERVICE)
                                ->whereHasMorph(
                                    'courtesable',
                                    PremiumService::class,
                                    fn($q) => $q->where('id', $service->id)
                                )->first();
                                
           
            if (isset($courtesyService->max_value) && $input['price'] <= $courtesyService->max_value) {
                $input['status'] = 2; //pago
                $input['price'] = 0; //cortesia

                $courtesyService->update([
                    'used' => true,
                    'used_at' => Carbon::now()
                ]);

                $usedCourtesyService = true;
            } else {
                $usedCourtesyService = false;
            }



            $shop = PremiumShopping::create($input);

            if ($usedCourtesyService) {
                $shop->purchase()->create([
                    'value' => 0,
                    'purchase_status_id' => PurchaseStatusEnum::PAYED
                ]);
            }

            DB::commit();

            if ($usedCourtesyService) {
                flash()->success('Servico de cortesia pelo Programa de Afiliados!');
                return redirect()->route('customer.premium_shoppings.show', ['premium_shopping' => $shop]);
            } 

            // se o serviço é customizado, o cliente vai pra home, e fica aguardando
            if (PremiumService::isCustom($input['premium_service_id'])) {
                flash()->success('Pedido de compra gerada com sucesso, nossa equipe vai analisar, e lhe informar o custo para o serviço.');
                return redirect()->route('customer.premium_shoppings.index');
            }

            flash()->success('Compra de serviço premium realizada com sucesso, por favor, conclua o pagamento');
            return redirect()->route('customer.premium_shoppings.show', ['premium_shopping' => $shop]);

        } catch (Exception $e) {
            DB::rollBack();
            $msg = 'Erro ao gravar a compra do serviço premium';
            logger()->error($msg, [$e->getMessage()]);

            flash()->error($msg . ': ' . $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    public function show(PremiumShopping $premium_shopping)
    {
        $premium_shopping->load('premium_service', 'package_item');
        return view('customer.premium_shoppings.show', compact('premium_shopping'));
    }

    public function checkout(PremiumShopping $premium_shopping)
    {
        $premium_shopping->load('premium_service', 'package_item');

        return view('customer.premium_shoppings.checkout', compact('premium_shopping'));
    }

    public function update(Request $request, $id)
    {
        logger()->debug('Retorno da api do paypal', [
            'data' => $request->all(),
            'id' => $id,
        ]);

        if ($request->get('payment_gateway') == 'paypal') {
            $data = [
                'paypal_transaction_id' => $request->get('transactionID'),
                'paypal_order_id' => $request->get('orderID'),
                'payment_gateway' => $request->get('payment_gateway'),
                'status' => 2,
            ];
        }

        try {
            $premium_shopping = PremiumShopping::findOrFail($id);
            $premium_shopping->update($data);
            return response()->json($request->all());
        } catch (Exception $e) {
            logger()->error('Has been an error on payment register', [
                $e->getMessage(),
                $e->getLine(),
            ]);
            return response()->json('Has been an error on payment register: ' . $e->getMessage(), 422);
        }
    }

    public function paypalFinish(Request $request, $id)
    {

    }

    public function finish(Request $request, $id, $gateway)
    {
        try {

            $premium_shopping = PremiumShopping::findOrFail($id);

            $transaction = (new Payment())->register($premium_shopping, $gateway, request()->all());

            return redirect($transaction->bill_url);

        } catch (Exception $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
