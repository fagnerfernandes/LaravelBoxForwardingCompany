<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Stock;

class StockObserver
{
    /** Quando entrar uma movimentação, atualiza o estoque do produto */
    public function saved(Stock $stock)
    {
        $product = Product::find($stock->product_id);
        if ($stock->type == 'I') {
            $product->increment('amount', $stock->amount);
        } else if ($stock->type == 'O') {
            $product->decrement('amount', $stock->amount);
        }
    }

    /** Quando deleta a movimentação tbm atualiza o estoque do produto */
    public function deleted(Stock $stock)
    {
        $product = Product::find($stock->product_id);
        if ($stock->type == 'I') {
            $product->decrement('amount', $stock->amount);
        } else if ($stock->type == 'O') {
            $product->increment('amount', $stock->amount);
        }
    }
}
