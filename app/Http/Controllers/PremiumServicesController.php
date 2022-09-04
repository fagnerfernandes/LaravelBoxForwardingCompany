<?php

namespace App\Http\Controllers;

use App\Http\Requests\PremiumServiceRequest;
use App\Models\PremiumService;
use Illuminate\Http\Request;

class PremiumServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = PremiumService::query();
        $rows = $query->orderBy('name')->paginate();

        return view('premium_services.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('premium_services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PremiumServiceRequest $request)
    {
        if (PremiumService::create($request->all())) {
            flash()->success('Serviço premium adicionado com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar o serviço premium');
        }
        return redirect()->route('premium_services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PremiumService $premium_service)
    {
        return view('premium_services.edit', compact('premium_service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PremiumServiceRequest $request, PremiumService $premium_service)
    {
        if ($premium_service->update($request->all())) {
            flash()->success('Serviço premium editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar a serviço premium');
        }
        return redirect()->route('premium_services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PremiumService $premium_service)
    {
        if ($premium_service->delete()) {
            flash()->success('Serviço premium removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o serviço premium');
        }
    }
}
