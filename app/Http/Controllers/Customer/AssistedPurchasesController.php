<?php

namespace App\Http\Controllers\Customer;

use App\ExternalApi\Payments\CambioReal;
use App\ExternalApi\Payments\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssistedPurchaseRequest;
use App\Models\AssistedPurchase;
use App\Models\PremiumShopping;
use Illuminate\Http\Request;

class AssistedPurchasesController extends Controller
{
    public function index()
    {
        $query = AssistedPurchase::query();

        if (request()->has('keyword') && !empty(request()->get('keyword'))) {
            $keyword = request()->get('keyword');

            $query->where(function($q) use($keyword) {
                foreach (AssistedPurchase::fields() as $field) {
                    $q->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $rows = $query->orderBy('title')->paginate(20);
        return view('customer.assisted_purchases.index', compact('rows'));
    }

    public function create()
    {
        return view('customer.assisted_purchases.create');
    }

    public function store(AssistedPurchaseRequest $request)
    {
        $input = $request->all();
        $input['customer_id'] = auth()->user()->getAttribute('userable_id');
        if (AssistedPurchase::create($input)) {
            flash()->success('Compra assistida adicionada com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar a compra assistida');
        }
        return redirect(route('customer.assisted-purchases.index'));
    }

    public function edit($id)
    {
        $row = AssistedPurchase::find($id);

        return view('customer.assisted_purchases.edit', compact('row'));
    }

    public function update(AssistedPurchaseRequest $request, $id)
    {
        $purchase = AssistedPurchase::findOrFail($id);
        if ($purchase->update($request->all())) {
            flash()->success('Compra assistida editadada com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar a compra assistida');
        }
        return redirect(route('customer.assisted-purchases.index'));
    }

    public function destroy($id)
    {
        $purchase = AssistedPurchase::findOrFail($id);
        if ($purchase->delete()) {
            flash()->success('Compra assistida removida com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover a compra assistida');
        }
        return redirect(route('customer.assisted-purchases.index'));
    }

    public function show($id)
    {
        $purchase = AssistedPurchase::findOrFail($id);
        return view('customer.assisted_purchases.show', compact('purchase'));
    }

    public function finish(Request $request, $id, $gateway)
    {
        try {
            $purchase = AssistedPurchase::findOrFail($id);

            $transaction = (new Payment())->register($purchase, $gateway, $request->all());
            return redirect($transaction->bill_url);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
