<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ExtraService;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageItemsController extends Controller
{
    public function index($package_id)
    {
        $query = PackageItem::query()->where('package_id', $package_id);

        $rows = $query->paginate();
        return view('customer.package_items.index')->with(compact('rows'));
    }

    public function all($available = null)
    {
        $query = PackageItem::query();
        $query->whereRaw('package_items.amount > package_items.amount_sent');

        $rows = $query->get();

        return view('customer.package_items.all')->with(compact('rows'));
    }

    public function chooseds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item' => 'required',
        ], [
            'item.required' => 'Escolha pelo menos um produto para fazer o envio',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        // nome do envio
        if (!empty($request->get('shipping_name'))) {
            session()->put('shipping_name', $request->get('shipping_name'));
        }

        // fica apenas com os itens escolhidos
        $items = collect($request->get('item'))->where('choosed', '1')->where('quantity', '>', 0)->toArray();
        session()->put('items', $items);

        $extra_services = ExtraService::orderBy('name')->get();
        // dd($items);
        return view('customer.package_items.chooseds')->with(compact('extra_services'));
    }
}
