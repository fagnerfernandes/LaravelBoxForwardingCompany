<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Shipping;

class DashboardController extends Controller
{
    public function index()
    {
        $shippings = Shipping::latest()->limit(5)->with('items', 'user')->get();
        $customers = Customer::latest()->limit(5)->with('user')->get();
        
        return view('dashboard.index', compact('shippings', 'customers'));
    }
}
