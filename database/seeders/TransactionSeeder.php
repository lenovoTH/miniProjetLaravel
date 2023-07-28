<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [
            ['typetransaction' => 'depot', 'montant' => 1000, 'date' => '2023-07-28', 'expediteur_id' => 1, 'recepteur_id' => 1, 'code' => null],
            ['typetransaction' => 'retrait', 'montant' => 2000, 'date' => '2023-07-28', 'expediteur_id' => 1, 'recepteur_id' => 1, 'code' => null],
            ['typetransaction' => 'transfert', 'montant' => 3000, 'date' => '2023-07-28', 'expediteur_id' => 1, 'recepteur_id' => 2, 'code' => 123720],
            ['typetransaction' => 'depot', 'montant' => 1500, 'date' => '2023-07-28', 'expediteur_id' => 3, 'recepteur_id' => 3, 'code' => null],
        ];
        DB::table('transactions')->insert($transactions);
    }
}
