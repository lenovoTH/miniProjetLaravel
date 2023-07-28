<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comptes = [
            ['client_id' => 1, 'fournisseur' => 'wave', 'solde' => 2000, 'numerocompte' => 'WV_774715759', 'code' => 'WV'],
            ['client_id' => 1, 'fournisseur' => 'orange_money', 'solde' => 5000, 'numerocompte' => 'OM_774715759', 'code' => '0M'],
            ['client_id' => 2, 'fournisseur' => 'wave', 'solde' => 10000, 'numerocompte' => 'WV_776190392', 'code' => 'WV'],
            ['client_id' => 3, 'fournisseur' => 'orange_money', 'solde' => 3000, 'numerocompte' => 'OM_775263525', 'code' => 'OM'],
            ['client_id' => 4, 'fournisseur' => 'cb', 'solde' => 20000, 'numerocompte' => 'CB_776948283', 'code' => 'CB'],
            ['client_id' => 4, 'fournisseur' => 'orange_money', 'solde' => 1500, 'numerocompte' => 'OM_776948283', 'code' => 'OM']
        ];
        DB::table('comptes')->insert($comptes);
    }
}
