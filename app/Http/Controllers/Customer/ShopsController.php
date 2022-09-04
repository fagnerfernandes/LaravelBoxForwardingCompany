<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopsController extends Controller
{
    public function index()
    {
        $rows = Shop::orderBy('name')->paginate();
        return view('customer.shops.index', compact('rows'));
    }
}
