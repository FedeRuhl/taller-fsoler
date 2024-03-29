<?php

use App\Http\Controllers\Api\DepotController;
use App\Http\Controllers\Api\GenericController;
use App\Http\Controllers\Api\GenericPresentationController;
use App\Http\Controllers\Api\HospitalizationController;
use App\Http\Controllers\Api\LaboratoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PhoneController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserClassController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WeeklyRequestController;
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

        Route::post('/{depot_id}/products/{product_id}', [DepotController::class, 'depotProduct'])
            ->name('depot_product');
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

        Route::post('/{request_id}/consume', [RequestController::class, 'consume'])
            ->name('consume');
    });

Route::prefix('laboratories')
    ->name('laboratories.')
    ->group(function () {
        Route::get('/', [LaboratoryController::class, 'index'])
            ->name('index');

        Route::post('/', [LaboratoryController::class, 'store'])
            ->name('store');

        Route::get('/{laboratory_id}', [LaboratoryController::class, 'show'])
            ->name('show');

        Route::put('/{laboratory_id}', [LaboratoryController::class, 'update'])
            ->name('update');

        Route::delete('/{laboratory_id}', [LaboratoryController::class, 'destroy'])
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

        Route::get('/order-type/{order_type_id}', [ProductController::class, 'indexByOrderType'])
            ->name('index_by_order_type');
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

        Route::post('/{hospitalization_id}/change-service', [HospitalizationController::class, 'changeService'])
            ->name('change_service');
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

Route::prefix('user-classes')
    ->name('user_classes.')
    ->group(function () {
        Route::get('/', [UserClassController::class, 'index'])
            ->name('index');

        Route::post('/', [UserClassController::class, 'store'])
            ->name('store');

        Route::get('/{user_class_id}', [UserClassController::class, 'show'])
            ->name('show');

        Route::put('/{user_class_id}', [UserClassController::class, 'update'])
            ->name('update');

        Route::delete('/{user_class_id}', [UserClassController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('index');

        Route::post('/', [UserController::class, 'store'])
            ->name('store');

        Route::get('/{user_id}', [UserController::class, 'show'])
            ->name('show');

        Route::put('/{user_id}', [UserController::class, 'update'])
            ->name('update');

        Route::delete('/{user_id}', [UserController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('phones')
    ->name('phones.')
    ->group(function () {
        Route::get('/person/{person_id}', [PhoneController::class, 'index'])
            ->name('index');

        Route::post('/', [PhoneController::class, 'store'])
            ->name('store');

        Route::get('/{phone_id}', [PhoneController::class, 'show'])
            ->name('show');

        Route::put('/{phone_id}', [PhoneController::class, 'update'])
            ->name('update');

        Route::delete('/{phone_id}', [PhoneController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('generic-presentations')
    ->name('generic_presentations.')
    ->group(function () {
        Route::get('/', [GenericPresentationController::class, 'index'])
            ->name('index');

        Route::post('/', [GenericPresentationController::class, 'store'])
            ->name('store');

        Route::get('/{generic_presentation_id}', [GenericPresentationController::class, 'show'])
            ->name('show');

        Route::put('/{generic_presentation_id}', [GenericPresentationController::class, 'update'])
            ->name('update');

        Route::delete('/{generic_presentation_id}', [GenericPresentationController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('weekly-requests')
    ->name('weekly_requests.')
    ->group(function () {
        Route::get('/', [WeeklyRequestController::class, 'index'])
            ->name('index');

        Route::post('/', [WeeklyRequestController::class, 'store'])
            ->name('store');

        Route::get('/{request_id}', [WeeklyRequestController::class, 'show'])
            ->name('show');

        Route::put('/{request_id}', [WeeklyRequestController::class, 'update'])
            ->name('update');

        Route::delete('/{request_id}', [WeeklyRequestController::class, 'destroy'])
            ->name('destroy');
    });