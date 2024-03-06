<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Produit;
use App\Models\User;

use App\Http\Controllers\ProduitController;
use App\Http\Requests\LoginRequest;

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

// ----- Produits
Route::get('/produits', [ProduitController::class, 'list']);

Route::post('/produits', [ProduitController::class, 'add']);

Route::delete('/produits/{idprod}', [ProduitController::class, 'delete']);

Route::put('/produits/{idprod}', [ProduitController::class, 'update']);

// ----- Users
Route::get('/users', function(Request $request) {
    $users = User::get();
    return response()->json($users);
});
Route::get('/users/{iduser}/produits', function(Request $request, $iduser) {
    $user = User::find($iduser); 
    if ($user) {
        $produits = User::find($iduser)->produits()->get();
        return response()->json($produits);   
    } else {
          return response()->json(["status" => 0, "message" => "user inexistant"],404);
    }

});

// -- gestion des tokens
Route::post('/login', function(LoginRequest $request){
   // -- LoginRequest a verifié que les email et password étaient présents
    // -- il faut maintenant vérifier que les identifiants sont corrects
    $credentials = request(['email','password']);
    if(!Auth::attempt($credentials)) {
        return response()->json([
            'status' => 0,
            'message' => 'Utilisateur inexistant ou pas autorisé'
        ],401);
    }
    // tout est ok, on peut générer le token
    $user = $request->user();
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->plainTextToken;

    return response()->json([
        'status' => 1,
        'accessToken' =>$token,
        'token_type' => 'Bearer',
        'user_id' => $user->id
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
