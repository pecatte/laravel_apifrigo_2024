<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Http\Requests\ProduitRequest;

class ProduitController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->has("search")) {
            $motcle = $request->search;
            // -- pour intégrer les infos du user pour chaque produit -> utiliser with()
            $produits = Produit::with('user')->where("nom","like","%$motcle%")->get();
        } else {
            // $produits = Produit::select("id","nom","qte")->get();
            // pour cacher les 'timestamps', il faut ajouter dans le model :
            //        protected $hidden = ['updated_at', 'created_at'];
            //$produits = Produit::get();
            // -- pour intégrer les infos du user pour chaque produit -> utiliser with()
            $produits = Produit::with('user')->get();
        }
        return response()->json($produits);
    }

    public function add(ProduitRequest $request) {
        /*
        la classe App/Http/Request/ProduitRequest
        permet de gérer les entrées et de les valider
        */    
        // -> on arriver ici dans le controleur  que si les données sont valides 
        $produit = new Produit;
        $produit->nom = $request->nom;
        $produit->qte = $request->qte;
        // - ajout pour lien avec le user
        $produit->user_id = $request->user_id;
        $ok = $produit->save();
        if ($ok)  {
            return response()->json(
                ["status" => 1, 
                "message" => "produit ajouté",
                "produit" => $produit
                ],
                 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"],400);
        } 
 
    }
    public function delete($idprod) {
        $produit = Produit::find($idprod); 
        if ($produit) {
            $ok = $produit->delete();
            if ($ok) {
                return response()->json(["status" => 1, "message" => "Produit supprimé"],200);
            } else {
                return response()->json(["status" => 0, "message" => "pb lors de la suppression"],400);
            }   
        } else {
              return response()->json(["status" => 0, "message" => "produit inexistant"],404);
        }
    }
    public function update(ProduitRequest $request, $idprod) {
        /* ------ avant la v10 de Laravel
        $validator = Validator::make($request->all(), [
            'id'  => ['required','numeric'],
            'qte'  => ['required','numeric'],
            'nom' => ['required','alpha'],
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 0, "message" => $validator->errors()],400);
        }
        */
        // -> ici les données ont déjà été validées par ProduitRequest
        $produit = Produit::find($idprod); 
        if ($produit) {
            $produit->nom = $request->nom;
            $produit->qte = $request->qte;
            // - ajout pour lien avec le user
            $produit->user_id = $request->user_id;
            $ok = $produit->save();
            if ($ok) {
                return response()->json(
                    ["status" => 1, 
                     "message" => "Produit modifié",
                     "produit" => $produit],
                     200);
            } else {
                return response()->json(["status" => 0, "message" => "pb lors de la modif"],400);
            }
        } else {
            return response()->json(["status" => 0, "message" => "produit inexistant"],404);
        }
    }
}
