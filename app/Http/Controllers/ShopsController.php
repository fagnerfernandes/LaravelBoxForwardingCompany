<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $shops = Shop::latest()->paginate($perPage);
        } else {
            $shops = Shop::latest()->paginate($perPage);
        }

        return view('shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ShopRequest $request)
    {
        $requestData = $request->all();
        if ($request->file('logo')->isValid()) {
            $filename = Str::slug($requestData['name']);
            $filename.= $request->file('logo')->getClientOriginalExtension();

            if (!$request->file('logo')->storeAs('shops', $filename)) {
                flash()->error('Erro ao fazer upload do logo');
                return redirect()->back()->withInput($requestData);
            }
            $requestData['logo'] = $filename;
        }

        if (Shop::create($requestData)) {
            flash()->success('Onde comprar adicionado com sucesso!');
        } else {
            flash()->error('Houve um erro ao adicionar Onde Comprar');
        }
        return redirect('shops')->with('flash_message', 'Shop added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $shop = Shop::findOrFail($id);

        return view('shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $shop = Shop::findOrFail($id);

        return view('shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ShopRequest $request, $id)
    {

        $requestData = $request->all();

        $shop = Shop::findOrFail($id);

        if (!empty($request->file('logo')) && $request->file('logo')->isValid()) {
            $filename = Str::slug($requestData['name']);
            $filename.= $request->file('logo')->getClientOriginalExtension();

            if (!$request->file('logo')->storeAs('shops', $filename)) {
                flash()->error('Erro ao fazer upload do logo');
                return redirect()->back()->withInput($requestData);
            }
            $requestData['logo'] = $filename;
        } else $requestData['logo'] = $shop->logo;

        $shop->update($requestData);

        return redirect('shops')->with('flash_message', 'Shop updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Shop::destroy($id);

        return redirect('shops')->with('flash_message', 'Shop deleted!');
    }
}
