<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('logout', [AuthController::class, 'logout']);

    //    Route::apiResource('products', ProductController::class);
    Route::controller(ProductController::class)->group(function () {
        Route::get('products', 'index')->middleware('abilities:server:read');
        Route::post('products', 'store')->middleware('abilities:server:create,server:read,server:update,server:delete');
        Route::get('products/{product:id}', 'show')->middleware('abilities:server:read');
        Route::put('products/{product:id}', 'update')->middleware('abilities:server:create,server:read,server:update,server:delete');
        Route::delete('products/{product:id}', 'destroy')->middleware('abilities:server:create,server:read,server:update,server:delete');
    });

    //    Route::apiResource('categories', CategoryController::class);
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories', 'index')->middleware('abilities:server:read');
        Route::post('categories', 'store')->middleware('abilities:server:create,server:read,server:update,server:delete');
        Route::get('categories/{category:id}', 'show')->middleware('abilities:server:read');
        Route::put('categories/{category:id}', 'update')->middleware('abilities:server:create,server:read,server:update,server:delete');
        Route::delete('categories/{category:id}', 'destroy')->middleware('abilities:server:create,server:read,server:update,server:delete');
    });
});
