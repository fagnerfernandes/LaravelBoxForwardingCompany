<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        $query = Order::query();
        $rows = $query->latest()->paginate();

        return view('orders.index', compact('rows'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'items.product');
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        DB::beginTransaction();
        try {

            $order->update($request->all());
            DB::commit();
            flash()->success('Pedido editado com sucesso!');
            return redirect()->to(route('orders.index'));

        } catch (Exception $e) {
            logger()->error('erro ao editar o pedido', [$e->getMessage(), $e->getLine()]);
            DB::rollBack();
            flash()->error('Houve um erro ao editar o pedido: '. $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }
}
