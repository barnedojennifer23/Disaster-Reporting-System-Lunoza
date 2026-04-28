<?php

use App\Http\Controllers\BarangayBantayController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BarangayBantayController::class, 'create'])->name('incidents.create');
Route::post('/incidents', [BarangayBantayController::class, 'store'])->name('incidents.store');
Route::get('/incidents', [BarangayBantayController::class, 'index'])->name('incidents.index');
Route::get('/incidents/{id}', [BarangayBantayController::class, 'show'])->name('incidents.show');
Route::put('/incidents/{id}/assign-team', [BarangayBantayController::class, 'assignTeam'])->name('incidents.assignTeam');
Route::put('/incidents/{id}/{status}', [BarangayBantayController::class, 'updateStatus'])->name('incidents.updateStatus');
Route::delete('/incidents/{id}', [BarangayBantayController::class, 'destroy'])->name('incidents.destroy');
