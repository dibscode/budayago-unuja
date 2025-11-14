<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\LaguController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('users', UserController::class);
    Route::resource('cultures', BudayaController::class);
    Route::post('/cultures/{id}/segments', [BudayaController::class, 'storeSegment'])->name('cultures.segments.store');
    Route::put('/cultures/{id}/segments', [BudayaController::class, 'updateSegment'])->name('cultures.segments.update');
    Route::delete('/cultures/{id}/segments/{segmentId}', [BudayaController::class, 'destroySegment'])->name('cultures.segments.destroy');

    Route::get('/lagu', [LaguController::class, 'index'])->name('lagu.index');
    Route::post('/lagu', [LaguController::class, 'store'])->name('lagu.store');
    Route::post('/cultures/{id}/lagu', [LaguController::class, 'store'])->name('cultures.lagu.store');
    Route::put('/lagu/{id}', [LaguController::class, 'update'])->name('lagu.update');
    Route::delete('/lagu/{id}', [LaguController::class, 'destroy'])->name('lagu.destroy');

    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
    Route::post('/cultures/{id}/arsip', [ArsipController::class, 'store'])->name('cultures.arsip.store');
    Route::put('/arsip/{id}', [ArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute KHUSUS PENJUAL
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {

});

// Rute KHUSUS PEMBELI
Route::middleware(['auth', 'role:pembeli'])->prefix('user')->name('user.')->group(function () {
  
});

require __DIR__ . '/auth.php';
