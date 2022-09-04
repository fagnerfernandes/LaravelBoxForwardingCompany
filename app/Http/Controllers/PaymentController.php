<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function result(Request $request)
    {
        logger()->info('Retorno do gateway de pagamento', [
            'dados' => $request->all(),
        ]);
    }

    public function cancel(Request $request)
    {
        logger()->info('Retorno do cancelamento de pagamento', [
            'dados' => $request->all(),
        ]);
    }

    public function notify(Request $request)
    {
        logger()->info('Retorno de notificao de pagamento', [
            'dados' => $request->all(),
        ]);
    }

    public function cambioRealNotification(Request  $request)
    {
        logger()->debug('retorno da api da Cambio Real', [
            'data' => $request->all(),
            'method' => $request->isMethod('POST') ? 'POST' : 'GET',
            'origin' => $_SERVER['HTTP_REFERER'],
        ]);

        if (!$request->has('token')) {
            logger()->error('request not has token field');
            return;
        }

        // consultar qual é a transacao
        $sql = "select * from (select id, cambioreal_token, '\App\Models\PremiumShopping' as type "
             . "from premium_shoppings union all select id, cambioreal_token, '\App\Models\Shipping' as type "
             . "from shippings)tb where cambioreal_token = '{$request->get('token')}'";

        $result = DB::selectOne($sql);
        if (!$result) {
            logger()->error('Transaction not found');
            return;
        }

        $model = new $result->type;
        $register = $model->first($result->id);

        $register->update(['status' => $result->data->status]);
    }
}
