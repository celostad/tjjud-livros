<?php

use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('livros.index'))->name('home');
Route::resource('livros', LivroController::class);
Route::resource('autores', AutorController::class)
    ->parameters([
        'autores' => 'autor',
    ]);

Route::resource('assuntos', AssuntoController::class);

Route::prefix('relatorio')->name('relatorio.')->group(function () {
    Route::get('/', [RelatorioController::class, 'index'])->name('index');
    Route::get('/pdf', [RelatorioController::class, 'pdf'])->name('pdf');
});
