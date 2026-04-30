<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('sales-pages')->name('sales-pages.')->group(function (){
        Route::get('/', [SalesPageController::class, 'index'])->name('index');
        Route::get('/create', [SalesPageController::class, 'create'])->name('create');
        Route::post('/', [SalesPageController::class, 'store'])->name('store');

        Route::post('/{salesPage}/regenerate', [SalesPageController::class, 'regenerate'])->name('regenerate');
        Route::get('/{salesPage}/export', [SalesPageController::class, 'exportHtml'])->name('export');

        Route::get('/{salesPage}', [SalesPageController::class, 'show'])->name('show');
        Route::delete('/{salesPage}', [SalesPageController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
