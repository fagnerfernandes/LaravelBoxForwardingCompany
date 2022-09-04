<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageItemRequest;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageItemsController extends Controller
{
    public function index($package_id)
    {
        $package = Package::with('items')->findOrFail($package_id);
        return view('package_items.index', compact('package'));
    }

    public function create($package_id)
    {
        $package = Package::with('items')->findOrFail($package_id);
        return view('package_items.create', compact('package'));
    }

    public function store(PackageItemRequest $request, $package_id)
    {
        $package = Package::findOrFail($package_id);

        $requestData = $request->all();
        $filename = Str::random(15) .'.jpg';

        // $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('photo')));
        // if (!Storage::put('package-items/'. $filename, $file)) {
        //     flash()->error('Houve um erro ao fazer upload da imagem');
        //     return redirect()->back()->withInput($request->all());
        // }
        // $requestData['image'] = $filename;

        if ($request->file('image')->isValid()) {
            $filename = Str::slug($request->get('reference')) .'_'. date('YmdHis');
            $filename .= '.'. $request->file('image')->getClientOriginalExtension();

            if (!$request->file('image')->storeAs('package-items', $filename)) {
                flash()->error('Houve um erro ao fazer upload da imagem');
                return redirect()->back()->withInput($request->all());
            }
            $requestData['image'] = $filename;
        } else $requestData['image'] = null;

        $requestData['user_id'] = $package->customer_id;
        $requestData['package_id'] = $package->id;

        if (PackageItem::create($requestData)) {
            flash()->success('Item adicionado com sucesso');
        } else {
            flash()->error('Houve um erro ao remover o item');
        }
        return redirect()->back();
    }

    public function destroy($package_id, $id)
    {
        $item = PackageItem::with('shipping_item')->findOrFail($id);

        // se ja houver uma solicitação de envio, nao vai deixar remover
        if (!empty($item->shipping_item) && (bool)$item->shipping_item->count()) {
            flash()->error('Não é possível remover este item, porque já foi solicitado envio dele.');
            return redirect()->back();
        }

        if ($item->delete()) {
            flash()->success('Item removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o item');
        }
        return redirect()->to(route('package-items.index', ['package_id' => $package_id]));
    }
}
