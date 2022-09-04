<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $query = Order::query();

        if (request()->has('keyword') && !empty(request()->get('keyword'))) {
            $keyword = request()->get('keyword');

            $query->where(function($q) use($keyword) {
                foreach (Order::fields() as $field) {
                    $q->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $rows = $query->latest()->paginate();
        return view('customer.orders.index', compact('rows'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'items.product');

        return view('customer.orders.show', compact('order'));
    }
}
