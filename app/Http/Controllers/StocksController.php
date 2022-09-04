<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Product;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();

        $rows = $query->latest()->paginate();

        return view('stocks.index', compact('rows'));
    }

    public function create()
    {
        $types = Stock::$types;
        $products = Product::orderBy('name')->pluck('name', 'id');
        return view('stocks.create', compact('types', 'products'));
    }

    public function store(StockRequest $request)
    {
        try {
            Stock::create($request->all());
            flash()->success('Movimentação de estoque criada com sucesso!');
            return redirect()->to(route('stocks.index'));
        } catch (Exception $e) {
            logger()->error('Erro ao criar movimentacao', [$e->getMessage()]);
            flash()->error('Houve um erro na movimentação do estoque: '. $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy(Stock $stock)
    {
        if ($stock->delete()) {
            flash()->success('Movimentação de estoque removida com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover a movimentação de estoque');
        }
        return redirect()->to(route('stocks.index'));
    }
}
