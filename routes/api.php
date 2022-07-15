<?php

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

Route::prefix('/account')->group( function() {
    Route::post('/store', [AccountController::class, 'store'])
        ->name('account.store');
    Route::put('/{id}' , [AccountController::class, 'update'])
        ->name('account.update');
    Route::delete('/{id}', [AccountController::class, 'destroy'])
        ->name('account.destroy');
});

Route::prefix('/item')->group( function() {
    Route::post('/store', [ItemController::class, 'store'])
        ->name('item.store');
    Route::put('/{id}' , [ItemController::class, 'update'])
        ->name('item.update');
    Route::delete('/{id}', [ItemController::class, 'destroy'])
        ->name('item.destroy');
});

Route::prefix('/project')->group( function() {
    Route::post('/store', [ProjectController::class, 'store'])
        ->name('project.store');
    Route::put('/{id}' , [ProjectController::class, 'update'])
        ->name('project.update');
    Route::delete('/{id}', [ProjectController::class, 'destroy'] )
        ->name('project.destroy');
});
