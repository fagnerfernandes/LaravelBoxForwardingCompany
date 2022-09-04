<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->group(function() {
    Route::get('', [Controllers\Api\ProductsController::class, 'index']);
    Route::get('news', [Controllers\Api\ProductsController::class, 'news']);
    Route::get('{slug}', [Controllers\Api\ProductsController::class, 'show']);
});

Route::prefix('cambioreal')->group(function() {
    Route::any('notifications', [
        Controllers\Customer\TransactionsController::class,
        'cambioRealNotifications'
    ]);

    Route::any('callback', function() {
        logger()->debug('retorno do cambio real', [
            'data' => request()->all(),
        ]);
    });

    Route::any('error', function() {
        logger()->debug('retorno do cambio real de erro', [
            'data' => request()->all(),
        ]);
    });
});

// Route::get('rogerio', function() {
//     return response()->json('OI');
// });
