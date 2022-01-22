<?php

use App\Http\Controllers\Api\DepotController;
use App\Http\Controllers\Api\GenericController;
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
    ->group(function() {
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
    ->group(function() {
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