<?php

use App\Http\Controllers;
use App\Http\Controllers\StatisticReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* 
Route::get('/teste', function() {
    return Auth::user()->credits()->with('transaction')->whereHas('transaction', function($query) {
        $query->where('status', 1);
    })->get();
}); */



Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('cambioreal')->group(function() {
    Route::any('notifications', [
        Controllers\Customer\TransactionsController::class,
        'cambioRealNotifications'
    ]);
    Route::any('callback', [
        Controllers\Customer\TransactionsController::class,
        'callback'
    ]);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('usps2', [Controllers\Customer\ShippingsController::class, 'usps2'])->name('shippings.usps2');
Route::get('skypostal2', [Controllers\Customer\ShippingsController::class, 'skypostal2'])->name('shippings.skypostal2');

Route::prefix('payment')->group(function() {
    Route::any('result', [Controllers\PaymentController::class, 'result']);
    Route::any('cancel', [Controllers\PaymentController::class, 'result']);
    Route::any('notify', [Controllers\PaymentController::class, 'notify']);
});

Route::get('shipping/calc', function() {
    return View('customer.shippings.shipping_calc');
})->name('shipping.calc');

Route::middleware('auth','verified')->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->userable_type == 'App\Models\Customer') {
            return view('customer.users.dashboard');
        } else {
            return redirect()->to(route('dashboard.index'));
        }
        // return view('dashboard');
    })->name('dashboard');

    // área do cliente
    Route::get('shippings/label/{id}', [Controllers\Customer\ShippingsController::class, 'label']);
    Route::get('calculaFrete', [Controllers\Customer\ShippingsController::class, 'calculaFrete'])->name('shippings.calculaFrete');
    Route::get('usps', [Controllers\Customer\ShippingsController::class, 'usps'])->name('shippings.usps');
    Route::get('skypostal', [Controllers\Customer\ShippingsController::class, 'skypostal'])->name('shippings.skypostal');

    // form de contato
    Route::get('contact', [Controllers\ContactFormController::class, 'index'])->name('contact_form.show');

    Route::prefix('customer')->name('customer.')->group(function() {
        Route::get('/thanks', function() {
            return view('thanks');
        });

        Route::resource('packages', Controllers\Customer\PackagesController::class)->only(['index', 'show']);

        Route::get('affiliates', [Controllers\Customer\AffiliatesController::class, 'index'])->name('affiliates.index');

        Route::resource('credits', Controllers\Customer\CreditsController::class, ['names' => 'credits'])->only('index', 'create', 'store', 'show');

        Route::resource('orders', Controllers\Customer\OrdersController::class, ['names' => 'orders'])->only('index', 'show');

        Route::prefix('shippings')->name('shippings.')->group(function() {
            Route::post('extra-services', [Controllers\Customer\ShippingsController::class, 'extraServicesPost'])->name('extra-services');

            Route::get('declaration', [Controllers\Customer\ShippingsController::class, 'declaration'])->name('declaration');
            Route::post('declaration', [Controllers\Customer\ShippingsController::class, 'declarationPost'])->name('declarationPost');
            Route::get('declaration/{package_item_id}/destroy', [Controllers\Customer\ShippingsController::class, 'declarationDestroy'])->name('declarationDestroy');

            Route::get('address', [Controllers\Customer\ShippingsController::class, 'chooseAddress'])->name('address');
            Route::post('address', [Controllers\Customer\ShippingsController::class, 'chooseAddressPost'])->name('addressPost');

            Route::get('method', [Controllers\Customer\ShippingsController::class, 'chooseMethod'])->name('method');
            Route::post('method', [Controllers\Customer\ShippingsController::class, 'chooseMethodPost'])->name('methodPost');

            Route::get('checkout', [Controllers\Customer\ShippingsController::class, 'checkout'])->name('checkout');
            Route::post('checkout', [Controllers\Customer\ShippingsController::class, 'checkoutPost'])->name('checkoutPost');

            Route::get('thanks', [Controllers\Customer\ShippingsController::class, 'thanks'])->name('thanks');

            Route::post('usps', [Controllers\Customer\CustomersController::class, 'usps']);
            Route::post('skypostal', [Controllers\Customer\CustomersController::class, 'skypostal']);

            Route::post('fee', [Controllers\Customer\ShippingsController::class, 'fee']);

        });

        Route::get('shippings/{id}/finish/{gateway}', [Controllers\Customer\ShippingsController::class, 'finish'])->name('shippings.pay');
        Route::resource('shippings', Controllers\Customer\ShippingsController::class)->except(['update', 'edit']);

        Route::get('assisted-purchases/{id}/finish/{gateway}', [Controllers\Customer\AssistedPurchasesController::class, 'finish'])->name('assisted_purchases.pay');
        Route::resource('assisted-purchases', Controllers\Customer\AssistedPurchasesController::class);

        Route::get('shops', [Controllers\Customer\ShopsController::class, 'index'])->name('shops.index');

        Route::prefix('me')->group(function() {
            Route::get('', [Controllers\Customer\CustomersController::class, 'me'])->name('me');
            Route::put('', [Controllers\Customer\CustomersController::class, 'update'])->name('me.update');
        });

        Route::resource('addresses', Controllers\Customer\AddressesController::class, ['names' => 'addresses']);

        Route::prefix('change-password')->group(function() {
            Route::get('', [Controllers\Customer\CustomersController::class, 'changePassword'])->name('change-password');
            Route::post('', [Controllers\Customer\CustomersController::class, 'changePasswordPost'])->name('change-password.update');
        });

        Route::get('items', [Controllers\Customer\PackageItemsController::class, 'all'])->name('items.available');
        Route::post('items', [Controllers\Customer\PackageItemsController::class, 'chooseds'])->name('items.chooseds');

        Route::get('premium-shoppings/{id}/finish/{gateway}', [Controllers\Customer\PremiumShoppingsController::class, 'finish'])->name('premium_shoppings.pay');
        Route::resource('premium-shoppings', Controllers\Customer\PremiumShoppingsController::class, ['names' => 'premium_shoppings'])->only(['index', 'create', 'store', 'show', 'update']);

        Route::get('credits/{id}/finish/{gateway}', [Controllers\Customer\CreditsController::class, 'finish'])->name('credits.pay');
        Route::resource('credits', Controllers\Customer\CreditsController::class, ['names' => 'credits'])->only(['index', 'create', 'store', 'show', 'update']);

        Route::get('faqs', [Controllers\Customer\FaqsController::class, 'index'])->name('faqs.index');

        Route::prefix('reports')->name('reports.')->group(function() {
            Route::get('statistics', [StatisticReportController::class, 'index'])->name('statistics.index');
        });
    });

    // rotas do admin
    Route::middleware('admin')->group(function() {
        Route::get('', [Controllers\DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('users', Controllers\UsersController::class, ['names' => 'users']);
        Route::resource('packages', Controllers\PackagesController::class, ['names' => 'packages']);

        Route::prefix('package-items/{package_id}')->name('package-items.')->group(function() {
            Route::get('', [Controllers\PackageItemsController::class, 'index'])->name('index');
            Route::get('create', [Controllers\PackageItemsController::class, 'create'])->name('create');
            Route::post('store', [Controllers\PackageItemsController::class, 'store'])->name('store');
            Route::delete('{id}', [Controllers\PackageItemsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('profile')->group(function() {
            Route::get('/{user}', [Controllers\UsersController::class, 'profileShow'])->name('admin.profile');
            Route::put('/{user}', [Controllers\UsersController::class, 'profileUpdate'])->name('admin.profile.update');
        });

        // Route::resource('package-items/{package_id}', Controllers\PackageItemsController::class, ['names' => 'package-items'])->only(['index', 'create', 'store', 'destroy']);
        Route::resource('shops', Controllers\ShopsController::class, ['names' => 'shops']);
        Route::resource('faqs', Controllers\FaqsController::class, ['names' => 'faqs']);

        Route::resource('box', Controllers\BoxController::class, ['names' => 'box'])->except('show');

        Route::get('customers/search', [Controllers\CustomersController::class, 'search']);
        Route::resource('customers', Controllers\CustomersController::class, ['names' => 'customers']);

        Route::get('customers/{customer}/change-password', [Controllers\CustomersController::class, 'editPassword'])->name('customers.password.edit');
        Route::post('customers/{customer}/change-password', [Controllers\CustomersController::class, 'updatePassword'])->name('customers.password.update');

        Route::prefix('premium-shoppings')->name('premium_shoppings.')->group(function() {
            Route::get('', [Controllers\PremiumShoppingsController::class, 'index'])->name('index');
            Route::get('{premium_shopping}', [Controllers\PremiumShoppingsController::class, 'show'])->name('show');
            Route::put('{premium_shopping}', [Controllers\PremiumShoppingsController::class, 'update'])->name('update');
        });

        Route::prefix('addresses/{user}')->name('addresses.')->group(function() {
            Route::get('', [Controllers\AddressesController::class, 'index'])->name('index');
            Route::get('create', [Controllers\AddressesController::class, 'create'])->name('create');
            Route::post('', [Controllers\AddressesController::class, 'store'])->name('store');
            Route::get('edit/{address}', [Controllers\AddressesController::class, 'edit'])->name('edit');
            Route::put('{address}', [Controllers\AddressesController::class, 'update'])->name('update');
            Route::delete('{address}', [Controllers\AddressesController::class, 'destroy'])->name('destroy');
        });

        Route::get('assisted-purchases/{id}/finished', [Controllers\AssistedPurchasesController::class, 'finished'])->name('assisted-purchases.finished');
        Route::get('assisted-purchases/{id}/canceled', [Controllers\AssistedPurchasesController::class, 'canceled'])->name('assisted-purchases.canceled');
        Route::get('assisted-purchases/{id}/invoice', [Controllers\AssistedPurchasesController::class, 'invoice'])->name('assisted-purchases.invoice');
        Route::get('assisted-purchases/{id}/paid', [Controllers\AssistedPurchasesController::class, 'paid'])->name('assisted-purchases.paid');
        Route::get('assisted-purchases/{id}/approved', [Controllers\AssistedPurchasesController::class, 'approved'])->name('assisted-purchases.approved');
        Route::resource('assisted-purchases', Controllers\AssistedPurchasesController::class, ['names' => 'assisted-purchases'])->only(['index', 'show']);

        Route::resource('extra-services', Controllers\ExtraServicesController::class, ['names' => 'extra-services'])->except(['show']);
        Route::resource('settings', Controllers\SettingsController::class, ['names' => 'settings'])->except('show');
        Route::resource('declaration-types', Controllers\DeclarationTypesController::class, ['names' => 'declaration_types'])->except('show');
        Route::resource('fees', Controllers\FeesController::class, ['names' => 'fees'])->except('show');
        Route::resource('premium-services', Controllers\PremiumServicesController::class, ['names' => 'premium_services'])->except('show');
        Route::resource('categories', Controllers\CategoriesController::class, ['names' => 'categories'])->except('show');
        Route::resource('products', Controllers\ProductsController::class, ['names' => 'products'])->except('show');
        Route::resource('mail-templates', Controllers\MailTemplateController::class, ['names' => 'mail_templates']);

        Route::delete('product-images/{id}', [Controllers\ProductImagesController::class, 'destroy'])->name('product_images.destroy');
        Route::prefix('product-images/{product_id}')->name('product_images.')->group(function() {
            Route::get('', [Controllers\ProductImagesController::class, 'index'])->name('index');
            Route::post('', [Controllers\ProductImagesController::class, 'store'])->name('store');
        });

        Route::post('shippings/{shipping}/new-weight', [Controllers\ShippingsController::class, 'changeWeight'])->name('shipping.change-weight');

        Route::resource('shippings', Controllers\ShippingsController::class, ['names' => 'shippings'])->only(['index', 'show', 'update']);

        Route::resource('stocks', Controllers\StocksController::class, ['names' => 'stocks'])->only(['index', 'create', 'store', 'destroy']);

        Route::resource('orders', Controllers\OrdersController::class, ['names' => 'orders'])->only(['index', 'show', 'update']);

        Route::resource('affiliate-groups', Controllers\AffiliateGroupController::class, ['names' => 'affiliate_groups'])->only(['index', 'create', 'edit', 'delete']);
    });
});

require __DIR__ . '/auth.php';
