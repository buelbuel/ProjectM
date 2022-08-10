<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group( function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(AccountController::class)->group( function () {
        Route::get('/account/{id}', 'show');
        Route::get('/accounts', 'index')
        ->name('accounts.index');
    });

    Route::controller(ContactController::class)->group( function () {
        Route::get('/contact/{id}', 'show');
        Route::get('/contacts', 'index')
        ->name('contacts.index');
    });

    Route::controller(ItemController::class)->group( function () {
        Route::get('/item/{number}', 'show');
        Route::get('/items', 'index')
        ->name('items.index');
    });
            
    Route::controller(ProjectController::class)->group( function () {
        Route::get('/project/{id}', 'show');
        Route::get('/projects', 'index')
        ->name('projects.index');
    });
});
