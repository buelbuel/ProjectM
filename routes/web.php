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

    Route::get('/account/{id}', [AccountController::class, 'show']);
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');

    Route::get('/contact/{id}', [ContactController::class, 'show']);
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

    Route::get('/item/{number}', [ItemController::class, 'show']);
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
        
    Route::get('/project/{id}', [ProjectController::class, 'show']);
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
});
