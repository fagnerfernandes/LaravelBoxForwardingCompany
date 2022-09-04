<?php

namespace App\Http\Controllers;

use App\Events\AssistedPurchaseApprovedEvent;
use App\Events\AssistedPurchaseCanceledEvent;
use App\Events\AssistedPurchaseFinishedEvent;
use App\ExternalApi\Payments\Iugu;
use App\Models\AssistedPurchase;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AssistedPurchasesController extends Controller
{
    public function index()
    {
        $query = AssistedPurchase::query()->latest();

        $rows = $query->paginate();
        return view('assisted_purchases.index', compact('rows'));
    }

    public function show(AssistedPurchase $assisted_purchase)
    {
        return view('assisted_purchases.show', compact('assisted_purchase'));
    }

    public function finished($id)
    {
        $purchase = AssistedPurchase::findOrFail($id);
        if ($purchase->update(['status' => AssistedPurchase::BOUGHT])) {
            event(new AssistedPurchaseFinishedEvent($purchase));
            flash()->success('Compra assistida concluída com sucesso!');
        } else {
            flash()->error('Houve um erro ao concluir a compra assistida');
        }
        return redirect()->back();
    }

    public function canceled($id)
    {
        $purchase = AssistedPurchase::findOrFail($id);
        if ($purchase->update(['status' => AssistedPurchase::CANCELED])) {
            event(new AssistedPurchaseCanceledEvent($purchase));
            flash()->success('Compra assistida cancelada com sucesso!');
        } else {
            flash()->error('Houve um erro ao cancelar a compra assistida');
        }
        return redirect()->back();
    }

    public function approved($id)
    {
        $purchase = AssistedPurchase::findOrFail($id);
        if ($purchase->update(['status' => 1])) {
            event(new AssistedPurchaseApprovedEvent($purchase));
            flash()->success('Compra aprovada com sucesso!');
        } else {
            flash()->error('Erro ao aprovar a compra');
        }
        return redirect()->back();
    }

    public function invoice($id)
    {
        echo "Gerando fatura...";
        try {
            $purchase = AssistedPurchase::with(['customer', 'customer.user', 'customer.addresses'])->find($id);

            $response = Http::get('https://economia.awesomeapi.com.br/last/USD-BRL');
            $dolar = (float)$response->json()['USDBRL']['high'];
            $item_value = ($purchase->price * $dolar);

            $iugu = new Iugu;
            $iugu->addItem($purchase->title, $purchase->quantity, $item_value);

            $payer = [
                'street' => 'Rua Salvador',
                'number' => '203',
                'neighborhood' => 'Jardim Real',
                'city' => 'Aruja',
                'uf' => 'SP',
                'zipcode' => '07402-830',
                'complement' => '',
                'document' => $purchase->customer->document,
                'name' => $purchase->customer->user->name,
                'phone' => '+5511969159344',
                'email' => $purchase->customer->user->email,
            ];
            $iugu->setPayer($payer);

            $orderId = Str::uuid();

            // $result = $iugu->boletoPayment($purchase->id, 1);
            $result = $iugu->boletoPayment($orderId, 1);
            // dd($result);

            if ($result['success']) {
                $purchase->update(['status' => 1, 'payment_link' => $result['url']]);
                return redirect($result['url']);
            }

            return "Erro: ". $result['error'];

        } catch (Exception $e) {
            throw new Exception('Houve um erro ao gerar a fatura: '. $e->getMessage());
        }
    }

    public function paid($id)
    {
        $assisted_purchase = AssistedPurchase::find($id);
        $assisted_purchase->update(['status' => 2]);

        flash()->success('Fatura marcada como paga');
        return redirect()->back();
    }
}
