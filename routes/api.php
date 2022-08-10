<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProjectController;
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

Route::prefix('/account')->controller(AccountController::class)->group( function () {
    Route::post('/store', 'store')->name('account.store');
    Route::put('/{id}' , 'update')->name('account.update');
    Route::delete('/{id}', 'destroy')->name('account.destroy');
});

Route::prefix('/contact')->controller(ContactController::class)->group( function () {
    Route::post('/store', 'store')->name('contact.store');
    Route::put('/{id}' , 'update')->name('contact.update');
    Route::delete('/{id}', 'destroy')->name('contact.destroy');
});

Route::prefix('/item')->controller(ItemController::class)->group( function () {
    Route::post('/store', 'store')->name('item.store');
    Route::put('/{id}', 'update')->name('item.update');
    Route::delete('/{id}', 'destroy')->name('item.destroy');
});

Route::prefix('/project')->controller(ProjectController::class)->group( function () {
    Route::post('/store', 'store')->name('project.store');
    Route::put('/{id}','update')->name('project.update');
    Route::delete('/{id}', 'destroy')->name('project.destroy');
});
