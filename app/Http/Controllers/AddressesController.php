<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest as Request;
use App\Models\Address;
use App\Models\User;

class AddressesController extends Controller
{
    public function index(User $user)
    {
        $rows = Address::where('user_id', $user->id)->latest()->paginate();
        return view('addresses.index', compact('rows', 'user'));
    }

    public function create(User $user)
    {
        return view('addresses.create')->with(compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $input = $request->all();
        $input['user_id'] = $user->id;

        if (Address::create( $input )) {
            flash()->success('Endereço cadastrado com sucesso!');
        } else {
            flash()->error('Houve um erro ao cadastrar o endereço');
        }
        return redirect()->route('addresses.index', ['user' => $user]);
    }

    public function edit(User $user, Address $address)
    {
        $row = $address;
        return view('addresses.edit', compact('row', 'user'));
    }

    public function update(Request $request, User $user, Address $address)
    {
        if ($address->update($request->all())) {
            flash()->success('Endereço editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o endereço');
        }
        return redirect()->route('addresses.index', ['user' => $user]);
    }

    public function destroy(User $user, Address $address)
    {
        if ($address->delete()) {
            flash()->success('Endereço removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o endereço');
        }
        return redirect()->route('addresses.index', ['user' => $user]);
    }
}
