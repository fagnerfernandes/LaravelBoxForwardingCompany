<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest as Request;
use App\Models\Address;

class AddressesController extends Controller
{
    public function index()
    {
        $query = Address::query();

//        dd(request()->route()->uri);

        if (request()->has('keyword') && !empty(request()->get('keyword'))) {
            $keyword = request()->get('keyword');

            $query->where(function($q) use($keyword) {
                foreach (Address::fields() as $field) {
                    $q->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $rows = $query->orderBy('name')->paginate();
        return view('customer.addresses.index', compact('rows'));
    }

    public function create()
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request)
    {
        if (Address::create($request->all())) {
            flash()->success('Endereço cadastrado com sucesso!');
        } else {
            flash()->error('Houve um erro ao cadastrar o endereço');
        }

        if ($request->has('back_to_referer') && (int)$request->get('back_to_referer') === 1) {
            return redirect()->back();
        }

        return redirect()->route('customer.addresses.index');
    }

    public function edit($id)
    {
        $row = Address::find($id);

        return view('customer.addresses.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        if ($address->update($request->all())) {
            flash()->success('Endereço editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o endereço');
        }
        return redirect()->route('customer.addresses.index');
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        if ($address->delete()) {
            flash()->success('Endereço removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o endereço');
        }
        return redirect()->route('customer.addresses.index');
    }
}
