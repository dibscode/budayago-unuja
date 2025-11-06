<?php

use App\Http\Controllers\BudayaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // users
    Route::resource('users',UserController::class);
    Route::resource('cultures', BudayaController::class);
    Route::post('/cultures/{id}/segments', [BudayaController::class, 'storeSegment'])->name('cultures.segments.store');
    Route::put('/cultures/{id}/segments', [BudayaController::class, 'updateSegment'])->name('cultures.segments.update');
    Route::delete('/cultures/{id}/segments/{segmentId}', [BudayaController::class, 'destroySegment'])->name('cultures.segments.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
