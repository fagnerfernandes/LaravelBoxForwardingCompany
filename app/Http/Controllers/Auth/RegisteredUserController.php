<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Services\AffiliateBenefitsService;
use App\Http\Requests\User\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::create($request->validated());

            $user = $customer->user()->create($request->validated());

            if ($request->affiliate_token) {
                //create the affiliate
                $affiliatedTo = Customer::where('affiliate_token', $request->affiliate_token)->first();
                $customer->update(['affiliated_to_id' => $affiliatedTo->id]);

                //grant all affiliate benefits according with the affiliated to group of benefits
                (new AffiliateBenefitsService($customer))->createBenefits();
            }

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('erro ao cadastrar usuario', [$e->getMessage()]);
            return back();
        }
    }
}
