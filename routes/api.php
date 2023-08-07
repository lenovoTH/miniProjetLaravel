<?php

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/clients', [ClientController::class, 'index']);
Route::apiResource('/clients', ClientController::class)->only(['index']);
Route::post('/transactions', [TransactionController::class, 'transfert']);
Route::get('/fournisseurs', [CompteController::class, 'getFournisseurs']);
// Route::get('/historiques/numero/{numero}/fournisseur/{fournisseur}', [TransactionController::class, 'historiqueByClient']);
Route::post('/historiques', [TransactionController::class, 'historiqueByClient']);
// Route::post('/historique2', [TransactionController::class, 'historique']);
Route::post('/auto', [TransactionController::class, 'autocomplete']);
Route::post('/client', [ClientController::class, 'store']);
Route::post('/compte', [CompteController::class, 'store']);
Route::get('/clientsbycompte', [ClientController::class, 'getClientsByCompteStatut']);
Route::post('/fermer', [CompteController::class, 'fermerOuBloquer']);
Route::get('/annuler/{idtrans}', [TransactionController::class, 'annulerTransaction']);
