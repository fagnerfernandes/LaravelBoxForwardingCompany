<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {
        $rows = Faq::orderBy('question')->get();
        return view('customer.faqs.index', compact('rows'));
    }
}
