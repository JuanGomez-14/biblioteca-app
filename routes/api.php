<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LibroController;
use App\Http\Controllers\Api\PrestamoController;
use App\Http\Controllers\Api\AutorController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Rutas para Libros
    Route::get('libros', [LibroController::class, 'index']);
    Route::get('libros/{id}', [LibroController::class, 'show']);
    Route::post('libros', [LibroController::class, 'store']);
    Route::put('libros/{id}', [LibroController::class, 'update']);
    Route::delete('libros/{id}', [LibroController::class, 'destroy']);

    // Rutas para Préstamos
    Route::get('prestamos', [PrestamoController::class, 'index']);
    Route::post('prestamos', [PrestamoController::class, 'store']);
    Route::put('prestamos/{id}/devolver', [PrestamoController::class, 'devolver']);

    // Rutas para Autores
    Route::delete('autores/{id}', [AutorController::class, 'destroy']);
});
