<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
    //
    public function list(Request $request)
    {
        $produits = Produit::select("id","nom","qte")->get();
        return response()->json($produits);
    }

}
