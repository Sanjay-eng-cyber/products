<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\UserPresenceController;
use App\Http\Controllers\frontend\FrontendAuthController;

// for customer routes
Route::domain(config('app.customer_domain'))->group(function () {
    Broadcast::routes(['middleware' => ['auth:customer']]);
    require __DIR__ . '/auth.php';
    Route::get('login', [FrontendAuthController::class, 'loginShow'])->name('frontend.login');
    Route::post('login', [FrontendAuthController::class, 'login'])->name('frontend.login.store');
    Route::get('sign-up', [FrontendAuthController::class, 'userRegisterShow'])->name('frontend.signUp');
    Route::post('sign-up/store', [FrontendAuthController::class, 'signUp'])->name('frontend.signUp.store');
    Route::group(['middleware' => 'auth:customer'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('frontend.dashboard');
        Route::post('order/store', [OrderController::class, 'store'])->name('frontend.order.store');
        Route::get('orders', [OrderController::class, 'index'])->name('frontend.order.index');
        Route::get('logout', [FrontendAuthController::class, 'logout'])->name('frontend.logout');

        Route::post('/push-subscribe', function (Illuminate\Http\Request $request) {
            auth()->user()->updatePushSubscription(
                $request->endpoint,
                $request->keys
            );
            return response()->json(['success' => true]);
        });
    });
});

// for admin routes
Route::domain(config('app.cms_domain'))->group(function () {
    Broadcast::routes(['middleware' => ['auth:admin']]);
    require __DIR__ . '/auth.php';
    Route::post('/push-subscribe', function (Illuminate\Http\Request $request) {
    auth()->user()->updatePushSubscription(
        $request->endpoint,
        $request->keys
    );
    return response()->json(['success' => true]);
});
    Route::get('login', [AuthController::class, 'loginShow'])->name('backend.login');
    Route::post('login', [AuthController::class, 'login'])->name('backend.login.store');
    Route::get('sign-up', [AuthController::class, 'userRegisterShow'])->name('backend.signUp');
    Route::post('sign-up/store', [AuthController::class, 'signUp'])->name('backend.signUp.store');
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', function () {
            return view('backend.index');
        })->name('backend.dashboard');

        //Products route
        Route::get('products', [ProductController::class, 'index'])->name('backend.product.index');
        Route::get('product/show/{id}', [ProductController::class, 'show'])->name('backend.product.show');
        Route::get('product/create', [ProductController::class, 'create'])->name('backend.product.create');
        Route::post('product/store', [ProductController::class, 'store'])->name('backend.product.store');
        Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('backend.product.edit');
        Route::post('product/update/{id}', [ProductController::class, 'update'])->name('backend.product.update');
        Route::get('product/delete/{id}', [ProductController::class, 'delete'])->name('backend.product.delete');

        //product import routes
        Route::get('products/import', [ProductController::class, 'importShow'])->name('backend.product.import');
        Route::post('products/import/submit', [ProductController::class, 'import'])->name('backend.product.import.submit');

        Route::get('orders', 'App\Http\Controllers\backend\OrderController@index')->name('backend.orders.index');
        Route::post('order/status/update', 'App\Http\Controllers\backend\OrderController@orderStatusUpdate')->name('backend.orders.status.update');

        Route::post('/users/{user}/online', [UserPresenceController::class, 'online']);
        Route::post('/users/{user}/offline', [UserPresenceController::class, 'offline']);

        Route::get('logout', [AuthController::class, 'logout'])->name('backend.logout');
    });
});
