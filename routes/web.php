<?php

use App\Http\Controllers\InfraestructuraController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('reginde.panel');
});

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/panel', [InfraestructuraController::class, 'index'])->name('reginde.panel');

    Route::get('/reginde', [InfraestructuraController::class, 'create'])->name('reginde.create');
    Route::post('/reginde', [InfraestructuraController::class, 'store'])->name('reginde.store');
    Route::get('/reginde/{id}/ver', [InfraestructuraController::class, 'show'])->name('reginde.show');
    Route::get('/reginde/{id}/editar', [InfraestructuraController::class, 'edit'])->name('reginde.edit');
    Route::get('/reginde/{id}/pdf', [InfraestructuraController::class, 'pdf'])->name('reginde.pdf');
    Route::put('/reginde/{id}', [InfraestructuraController::class, 'update'])->name('reginde.update');
    Route::delete('/reginde/{id}', [InfraestructuraController::class, 'destroy'])->name('reginde.destroy');
});
