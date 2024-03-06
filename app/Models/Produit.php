<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $hidden = ['updated_at', 'created_at'];
    public function user() {
        return $this->belongsTo(User::class); 
         // par convention la clé de user doit se nommée 'id'
         //  et la clé étrangère dans Livre 'user_id'
    }

}
