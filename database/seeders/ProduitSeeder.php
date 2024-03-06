<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produits')->delete();
        DB::table('produits')->insert([
        'nom' => 'Choux',
        'qte' => 4,
        'user_id' => 2
        ]);
        DB::table('produits')->insert([
        'nom' => 'Beurre',
        'qte' => 1,
        'user_id' => 2
        ]);
        DB::table('produits')->insert([
        'nom' => 'Olives',
        'qte' => 3,
        'user_id' => 1
        ]);

    }
}
