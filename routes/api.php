<?php

use App\Http\Controllers\Api\DepotController;
use App\Http\Controllers\Api\GenericController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('depots')
    ->name('depots.')
    ->group(function () {
        Route::get('/', [DepotController::class, 'index'])
            ->name('index');

        Route::post('/', [DepotController::class, 'store'])
            ->name('store');

        Route::get('/{depot_id}', [DepotController::class, 'show'])
            ->name('show');

        Route::put('/{depot_id}', [DepotController::class, 'update'])
            ->name('update');

        Route::delete('/{depot_id}', [DepotController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('generics')
    ->name('generics.')
    ->group(function () {
        Route::get('/', [GenericController::class, 'index'])
            ->name('index');

        Route::post('/', [GenericController::class, 'store'])
            ->name('store');

        Route::get('/{generic_id}', [GenericController::class, 'show'])
            ->name('show');

        Route::put('/{generic_id}', [GenericController::class, 'update'])
            ->name('update');

        Route::delete('/{generic_id}', [GenericController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('requests')
    ->name('requests.')
    ->group(function () {
        Route::get('/', [RequestController::class, 'index'])
            ->name('index');

        Route::post('/', [RequestController::class, 'store'])
            ->name('store');

        Route::get('/{request_id}', [RequestController::class, 'show'])
            ->name('show');

        Route::put('/{request_id}', [RequestController::class, 'update'])
            ->name('update');

        Route::delete('/{request_id}', [RequestController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])
            ->name('index');

        Route::post('/', [ProductController::class, 'store'])
            ->name('store');

        Route::get('/{product_id}', [ProductController::class, 'show'])
            ->name('show');

        Route::put('/{product_id}', [ProductController::class, 'update'])
            ->name('update');

        Route::delete('/{product_id}', [ProductController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('orders')
    ->name('orders.')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])
            ->name('index');

        Route::post('/', [OrderController::class, 'store'])
            ->name('store');

        Route::get('/{order_id}', [OrderController::class, 'show'])
            ->name('show');

        Route::put('/{order_id}', [OrderController::class, 'update'])
            ->name('update');

        Route::delete('/{order_id}', [OrderController::class, 'destroy'])
            ->name('destroy');
    });