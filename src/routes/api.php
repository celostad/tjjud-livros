<?php

use App\Http\Controllers\Api\LivroApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('livros', LivroApiController::class)
    ->names('api.livros');
