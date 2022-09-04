<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    public function creating(Transaction $transaction)
    {
        $transaction->status = $transaction->getStatus($transaction->gateway, $transaction->status);
    }

    public function updating(Transaction $transaction)
    {
        $transaction->status = $transaction->getStatus($transaction->gateway, $transaction->status);
    }
}
