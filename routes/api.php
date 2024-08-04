<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProduitController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FournisseurController;



Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::apiResource('produits', ProduitController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('fournisseurs', FournisseurController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
