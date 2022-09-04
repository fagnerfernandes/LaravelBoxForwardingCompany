<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeclarationType;
use App\Http\Requests\DeclarationTypeRequest;

class DeclarationTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DeclarationType::query();
        $rows = $query->orderBy('name')->paginate();

        return view('declaration_types.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('declaration_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeclarationTypeRequest $request)
    {
        if (DeclarationType::create($request->all())) {
            flash()->success('Tipo de declaração adicionado com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar o tipo de declaração');
        }
        return redirect()->route('declaration_types.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DeclarationType $declaration_type)
    {
        return view('declaration_types.edit', compact('declaration_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeclarationTypeRequest $request, DeclarationType $declaration_type)
    {
        if ($declaration_type->update($request->all())) {
            flash()->success('Tipo de declaração editada com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o tipo de declaração');
        }
        return redirect()->route('declaration_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeclarationType $declaration_type)
    {
        //dd('oi', $declaration_type);
        if ($declaration_type->delete()) {
            flash()->success('Tipo de declaração removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o tipo de declaração');
        }
        return redirect()->route('declaration_types.index');
    }
}
