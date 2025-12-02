<?php

use Illuminate\Support\Facades\Route;
use Kazuha\AdminPainel\Http\Controllers\UserController;

Route::prefix('admin')->name('kazuha.admin.')->middleware(['web','auth'])->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/users/{id}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
    Route::get('/stop-impersonate', [UserController::class, 'stopImpersonate'])->name('stop.impersonate');
});
