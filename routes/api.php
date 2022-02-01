<?php

use App\Http\Controllers\Api\DepotController;
use App\Http\Controllers\Api\GenericController;
use App\Http\Controllers\Api\HospitalizationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UnitController;
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

Route::prefix('services')
    ->name('services.')
    ->group(function () {
        Route::get('/', [ServiceController::class, 'index'])
            ->name('index');

        Route::post('/', [ServiceController::class, 'store'])
            ->name('store');

        Route::get('/{service_id}', [ServiceController::class, 'show'])
            ->name('show');

        Route::put('/{service_id}', [ServiceController::class, 'update'])
            ->name('update');

        Route::delete('/{service_id}', [ServiceController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('patients')
    ->name('patients.')
    ->group(function () {
        Route::get('/', [PatientController::class, 'index'])
            ->name('index');

        Route::post('/', [PatientController::class, 'store'])
            ->name('store');

        Route::get('/{patient_id}', [PatientController::class, 'show'])
            ->name('show');

        Route::put('/{patient_id}', [PatientController::class, 'update'])
            ->name('update');

        Route::delete('/{patient_id}', [PatientController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('hospitalizations')
    ->name('hospitalizations.')
    ->group(function () {
        Route::get('/', [HospitalizationController::class, 'index'])
            ->name('index');

        Route::post('/', [HospitalizationController::class, 'store'])
            ->name('store');

        Route::get('/{hospitalization_id}', [HospitalizationController::class, 'show'])
            ->name('show');

        Route::put('/{hospitalization_id}', [HospitalizationController::class, 'update'])
            ->name('update');

        Route::delete('/{hospitalization_id}', [HospitalizationController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('suppliers')
    ->name('suppliers.')
    ->group(function () {
        Route::get('/', [SupplierController::class, 'index'])
            ->name('index');

        Route::post('/', [SupplierController::class, 'store'])
            ->name('store');

        Route::get('/{supplier_id}', [SupplierController::class, 'show'])
            ->name('show');

        Route::put('/{supplier_id}', [SupplierController::class, 'update'])
            ->name('update');

        Route::delete('/{supplier_id}', [SupplierController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('units')
    ->name('units.')
    ->group(function () {
        Route::get('/', [UnitController::class, 'index'])
            ->name('index');

        Route::post('/', [UnitController::class, 'store'])
            ->name('store');

        Route::get('/{unit_id}', [UnitController::class, 'show'])
            ->name('show');

        Route::put('/{unit_id}', [UnitController::class, 'update'])
            ->name('update');

        Route::delete('/{unit_id}', [UnitController::class, 'destroy'])
            ->name('destroy');
    });