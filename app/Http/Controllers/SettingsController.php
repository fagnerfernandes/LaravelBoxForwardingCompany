<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Setting::query();
        $rows = $query->orderBy('key')->paginate();

        return view('settings.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        if (Setting::create($request->all())) {
            flash()->success('Configuração adicionada com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar a configuração');
        }
        return redirect()->route('settings.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        if ($setting->update($request->all())) {
            flash()->success('Configuração editada com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar a configuração');
        }
        return redirect()->route('settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        if ($setting->delete()) {
            flash()->success('Configuração removida com sucesso!');
        } else {
            flash()->error('Houve um erro ao fazer a configuração');
        }
        return redirect()->route('settings.index');
    }
}
