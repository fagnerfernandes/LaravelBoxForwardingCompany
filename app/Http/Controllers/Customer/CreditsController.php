<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\ExternalApi\Payments\CambioReal;
use App\ExternalApi\Payments\Payment;

class CreditsController extends Controller
{
    public function index()
    {
        $query = Credit::query()->with('transaction')->where('is_buying', true);
        $rows = $query->latest()->get();
        //$rows = $query->latest()->paginate();

        return view('customer.credits.index', compact('rows'));
    }

    public function create()
    {
        return view('customer.credits.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        try {
            $input = $request->all();
            $input['description'] = 'Compra de créditos';
            $input['type'] = 'in';
            $input['is_buying'] = true;

            $data = Credit::create($input);
            flash()->success('Compra de créditos efetuada com sucesso, os créditos serão creditados após a confirmação de pagamento');

            return redirect()->to(env('APP_URL').'/customer/credits/'.$data['id']);

        } catch (Exception $e) {
            logger()->error('erro no cadastro de creditos', [$e->getMessage(), $e->getLine()]);
            flash()->error('Houve um erro ao adicionar créditos: '. $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    public function show(Credit $credit)
    {
        $credit->load('transaction');

        return view('customer.credits.show', compact('credit'));
    }

    public function finish(Request $request, $id, $gateway)
    {
        try {
            $credit = Credit::findOrFail($id);

            $transaction = (new Payment())->register($credit, $gateway, request()->all());

            if ($credit->type == 'in' && (int)$transaction->status === 1) {
                $credit->user()->increment('credits_total', $credit->amount);
            } else if ($credit->type == 'out') {
                $credit->user()->decrement('credits_total', $credit->amount);
            }

            return redirect($transaction->bill_url);

        } catch (Exception $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

}
