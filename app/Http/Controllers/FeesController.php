<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Http\Requests\FeeRequest;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Fee::query();
        $rows = $query->orderBy('weight_min')->paginate();

        return view('fees.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeRequest $request)
    {
        if (Fee::create($request->all())) {
            flash()->success('Taxa adicionada com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar a taxa');
        }
        return redirect()->route('fees.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fee $fee)
    {
        return view('fees.edit', compact('fee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeeRequest $request, Fee $fee)
    {
        if ($fee->update($request->all())) {
            flash()->success('Taxa editada com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar a taxa');
        }
        return redirect()->route('fees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fee $fee)
    {
        if ($fee->delete()) {
            flash()->success('Taxa removida com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover a taxa');
        }
        return redirect()->route('fees.index');
    }
}
