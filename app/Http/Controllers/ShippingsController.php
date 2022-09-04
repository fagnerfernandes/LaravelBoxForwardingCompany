<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseStatusEnum;
use App\Events\PackageDeliveredEvent;
use App\Http\Requests\ShippingUpdateRequest;
use App\Models\Shipping;
use App\Models\Box;
use Exception;
use Illuminate\Http\Request;

class ShippingsController extends Controller
{
    public function index()
    {
        $query = Shipping::query();

        $rows = $query->select(['shippings.*', 'purchases.id as purchase_id', 'purchases.purchase_status_id'])
            ->leftJoin('purchases', 'purchases.purchasable_id', '=', 'shippings.id')
            ->where('purchases.purchasable_type', '=', Shipping::class)
            ->orderBy('purchases.purchase_status_id', 'DESC')
            ->orderBy('shippings.status', 'ASC')
            ->orderBy('shippings.created_at', 'DESC')
            ->paginate();

        /* $rows = $query->latest()->with('purchase')->whereHas('purchase', function($q) {
            $q->where('purchase_status_id', PurchaseStatusEnum::PAYED);
        })->orderBy('status', 'ASC')
        ->orderBy('purchase.purchase_status_id', 'DESC')
        ->paginate(); */
        return view('shippings.index', compact('rows'));
    }

    public function show(Shipping $shipping)
    {
        $shipping->load('items', 'items.package_item', 'items.declaration_type',
                            'user', 'extra_services', 'extra_services.extra_service');

        $box = Box::orderBy('name')->pluck('name', 'id');

        return view('shippings.show', compact('shipping', 'box'));
    }

    public function update(ShippingUpdateRequest $request, Shipping $shipping)
    {
        try {
            $oldStatus = $shipping->status;
            $newStatus = $request->status;
    
            $shipping->update($request->all());

            //se alterou o status, dispara envento
            if ($oldStatus != $newStatus) {
                switch ($newStatus) {
                    case Shipping::PENDING:
                        # code...
                        break;
                    case Shipping::INPROGRESS:
                        # code...
                        break;
                    case Shipping::DELIVERED:
                        event(new PackageDeliveredEvent($shipping->user, $shipping->address, $shipping));
                        break;
                    case Shipping::CANCELED:
                        # code...
                        break;
                }
            }
    
            flash()->success('Envio atualizado com sucesso!');
            //return redirect()->action('show', ['shipping' => $shipping]);// route('shippings.show', ['shipping', $shipping]);// redirect()->to(url('shippings'));
            return redirect()->route('shippings.show', ['shipping' => $shipping]);  
        } catch (Exception $e) {
            logger()->error('Erro ao atualizar o envio', [$e->getMessage(), $e->getLine()]);
            flash()->error('Houve um erro ao atualizar o envio');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function changeWeight(Request $request, Shipping $shipping) {
        $shipping->update(['weight_mensured' => $request->newWeight]);


        return $this->show($shipping);
    }
}
