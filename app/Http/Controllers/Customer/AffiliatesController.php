<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliatesController extends Controller
{
    public function index()
    {
        $indicates = Auth::user()->userable->affiliates->count();
        return view('customer.affiliates.index', compact('indicates')); 
    }
}
