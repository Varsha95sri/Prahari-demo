<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CasesController;
use App\Http\Controllers\Admin\ChallanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PrahariController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('praharis', PrahariController::class);
        Route::resource('cases', CasesController::class);
        Route::resource('challans', ChallanController::class);
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::patch('/payments/{id}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
        Route::patch('/payments/{id}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });


    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
