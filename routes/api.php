<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandeItemController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UserController;

Route::apiResource('users', UserController::class);


// Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('produits', ProduitController::class);
    Route::apiResource('fournisseurs', FournisseurController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('commandes', CommandeController::class);
    Route::apiResource('commande_items', CommandeItemController::class);
    Route::apiResource('inventaires', InventaireController::class);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
