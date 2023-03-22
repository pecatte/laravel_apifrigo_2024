<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Produit;
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
Route::get('/', function (Request $request) {
    return response()->json(["message" => "Bienvenue dans l'API de gestion du frigo"],200);
});
/*
Route::get('/produits', function (Request $request) {
    $produits = Produit::select("id","nom","qte")->get();
    return response()->json($produits,200);
});
*/
Route::get('/produits', [App\Http\Controllers\ProduitController::class, 'list']);

Route::post('/produits', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'qte'  => ['required','numeric'],
        'nom' => ['required','alpha'],
    ]);
    if ($validator->fails()) {
        return response()->json(["status" => 0, "message" => $validator->errors()],400);
    }

    $produit = new Produit;
    $produit->nom = $request->nom;
    $produit->qte = $request->qte;
    $ok = $produit->save();
    if ($ok)  {
        return response()->json(["status" => 1, "message" => "livre ajouté"], 201);
    } else {
        return response()->json(["status" => 0, "message" => "pb lors de l'ajout"],400);
    } 
} );

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
