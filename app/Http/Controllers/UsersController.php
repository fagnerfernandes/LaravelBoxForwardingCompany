<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index()
    {
        $query = User::query()->admin();

        $rows = $query->orderBy('name')->paginate(20);
        return view('users.index', compact('rows'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (User::create($request->all())) {
            flash()->success('Usuário cadastrado com sucesso!');
        } else {
            flash()->error('Houve um erro ao cadastrar o usuário');
        }
        return redirect(url('users'));
    }

    public function edit($id)
    {
        $row = User::find($id);

        return view('users.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($id);

        if ($user->update($request->all())) {
            flash()->success('Usuário editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o usuário');
        }
        return redirect(url('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            flash()->success('Usuário removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o usuário');
        }
        return redirect(url('users'));
    }

    public function profileShow()
    {
        return view('users.profile')->withUser(Auth::user());
    }

    public function profileUpdate(UpdateProfileRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->fill($request->validated());
            
            if($request->has('avatar')) {
                $user->avatar = $request->file('avatar')->store('avatars');
            }
            
            $user->update();

            DB::commit();

            $user->fresh();

            // Auth::login($user);

            flash()->success('Dados editados com sucesso!');
            return redirect(route('dashboard'));
        } catch (Exception $e) {
            DB::rollBack();
            flash()->error('Houve um erro ao editar os dados');
            return redirect()->back()->withInput($request->all());
        }
    }
}
