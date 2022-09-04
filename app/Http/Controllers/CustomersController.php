<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Requests\Customer\UpdatePasswordRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
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
            $customers = Customer::with('user')->latest()->paginate($perPage);
        } else {
            $customers = Customer::with('user')->latest()->paginate($perPage);
        }

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateCustomerRequest $request)
    {
        DB::beginTransaction();
        $requestData = $request->only(['document', 'active', 'suite']);
        $customer = Customer::create($requestData);
        if (!$customer) {
            DB::rollBack();
            flash()->error('Houve um erro ao cadastrar o cliente');
            return redirect()->back()->withInput($request->all());
        }

        if (!$customer->user()->create($request->get('user'))) {
            DB::rollBack();
            flash()->error('Houve um erro ao criar a conta do cliente');
            return redirect()->back()->withInput($request->all());
        }
        DB::commit();

        flash()->success('Cliente cadastrado com sucesso!');
        return redirect(route('customers.index'));
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
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
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
        $customer = Customer::findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $requestData = $request->all();
        
        $customer = Customer::findOrFail($id);

        $user = collect($requestData['user'])->toArray();
        if (
            $customer->update($requestData) &&
            $customer->user()->update($user)
        ) {
            flash()->success('Cliente editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o cliente');
        }

        return redirect('customers');
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
        Customer::destroy($id);

        return redirect('customers')->with('flash_message', 'Customer deleted!');
    }

    public function search(Request $request)
    {
        $rows = [];
        if ($request->has('search') && !empty($request->get('search'))) {
            $rows = Customer::search($request->get('search'));      
        }
        return response()->json(['items' => $rows]);
    }

    public function editPassword(Customer $customer) {
        return View('customers.edit_password')->withCustomer($customer);
    }

    public function updatePassword(UpdatePasswordRequest $request, Customer $customer) {
        try {
            $customer->user()->update(['password' => Hash::make($request->user['password'])]);

            flash()->success('Senha de Cliente alterada com sucesso!');
        } catch (\Exception $exception) {
            dd($exception);
            flash()->error('Houve um erro ao alterar a senha do cliente.');
        }

        return redirect('customers');
    }
}
