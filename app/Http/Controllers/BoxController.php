<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoxRequest;
use App\Models\Box;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Box::query();
        $rows = $query->orderBy('name')->paginate();

        return view('box.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('box.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoxRequest $request)
    {
        if (Box::create($request->all())) {
            flash()->success('CAIXA adicionada com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar a CAIXA');
        }
        return redirect()->route('box.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Box $box)
    {
        return view('box.edit', compact('box'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoxRequest $request, Box $box)
    {
        if ($box->update($request->all())) {
            flash()->success('CAIXA editada com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar a CAIXA');
        }
        return redirect()->route('box.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        if ($box->delete()) {
            flash()->success('CAIXA removida com sucesso!');
        } else {
            flash()->error('Houve um erro ao fazer a CAIXA');
        }
        return redirect()->route('box.index');
    }
}
