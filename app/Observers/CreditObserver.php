<?php

namespace App\Observers;

use App\Models\Credit;
use Illuminate\Support\Facades\Log;

class CreditObserver
{

    public function saved(Credit $credit)
    {
        //Log::debug($credit);
        // if ($credit->type == 'in' && (int)$credit->status === 1) {
        //     $credit->user()->increment('credits_total', $credit->amount);
        // } else if ($credit->type == 'out') {
        //     $credit->user()->decrement('credits_total', $credit->amount);
        // }
    }

    public function deleted(Credit $credit)
    {
        /* if ($credit->type == 'out' && (int)$credit->status === 1) {
            $credit->user()->increment('credits_total', $credit->amount);
        } else if ($credit->type == 'in') {
            $credit->user()->decrement('credits_total', $credit->amount);
        } */
    }
}
