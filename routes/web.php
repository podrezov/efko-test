<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

# auth routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    # vacations
    Route::prefix('vacations')->as('vacations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VacationController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\VacationController::class, 'search'])->name('search');
        Route::post('/', [\App\Http\Controllers\VacationController::class, 'store'])->name('store');
        Route::post('/{vacation}/fixed', [\App\Http\Controllers\VacationController::class, 'fixed'])->name('fixed');
    });
});

require __DIR__ . '/auth.php';
