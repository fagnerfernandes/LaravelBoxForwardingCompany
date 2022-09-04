<?php

namespace App\Http\Controllers\Customer;

use App\ExternalApi\Payments\CambioReal;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Credit;

class TransactionsController extends Controller
{
    public function cambioRealNotifications()
    {

        // no formulario de pagamento da CambioReal, o cliente pode optar por pagar depois e tem um link
        // que redireciona para a url de callback de sucesso sem passar nenhuma informacao, pois o cliente ainda nao pagou
        // entao redirecionamos ele para a Home page
        if(request()->all()==null){
            return redirect(env('APP_URL').'/dashboard');
        }

        logger()->debug('retorno do cambio real (notifications)', [
            'data' => request()->all(),
            'method' => request()->getMethod(),
        ]);
        $input = request()->all();

        try {
            $transaction                = Transaction::whereToken($input['token'])->firstOrFail();
            $statusAntesTransaction     = $transaction['status'];
            $res                        = (new CambioReal())->response($transaction->token);
            $statusDepoisTransaction    = $res['status'];
            $transaction->update(['status' => $res['status']]);

            //status mudou para aprovado
            //e for operacao de add credito
            //add o credit ao cliente
            if($statusAntesTransaction!=1
                &&$statusDepoisTransaction=='SOLICITACAO_PAGO'
                &&$transaction['transactionable_type']=='App\Models\Credit'
            ){
                    $credit = Credit::findOrFail($transaction['transactionable_id']);
                    $credit->user()->increment('credits_total', $credit->amount);
            }

        } catch (\Exception $e) {
            logger()->error('Erro ao fazer o tratamento da transacao', [
                $e->getMessage(),
                $e->getFile(),
                $e->getLine(),
            ]);
        }
    }

    public function callback(){
        die('Restrito');
    }
}
