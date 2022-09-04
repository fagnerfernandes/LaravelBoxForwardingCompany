<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtraServiceRequest;
use App\Models\ExtraService;
use Illuminate\Http\Request;

class ExtraServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = ExtraService::query();

        $rows = $query->paginate();
        return view('extra_services.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('extra_services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExtraServiceRequest $request)
    {
        if (ExtraService::create($request->all())) {
            flash()->success('Serviço extra adicionado com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar o serviço extra');
        }
        return redirect(route('extra-services.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ExtraService  $extra_service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(ExtraService $extra_service)
    {
        return view('extra_services.show', compact('extra_service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraService $extra_service)
    {
        return view('extra_services.edit', compact('extra_service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExtraServiceRequest $request, ExtraService $extra_service)
    {
        if ($extra_service->update($request->all())) {
            flash()->success('Serviço extra editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o Serviço extra');
        }
        return redirect(route('extra-services.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraService $extra_service)
    {
        if ($extra_service->delete()) {
            flash()->success('Serviço extra removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o serviço extra');
        }
        return redirect(route('extra-services.index'));
    }
}
