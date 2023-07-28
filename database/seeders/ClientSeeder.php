<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['nom' => 'diallo', 'prenom' => 'sira', 'telephone' => 774715759],
            ['nom' => 'gueye', 'prenom' => 'mouha', 'telephone' => 776190392],
            ['nom' => 'sow', 'prenom' => 'hali', 'telephone' => 775263525],
            ['nom' => 'dieng', 'prenom' => 'ibou', 'telephone' => 776948283],
            ['nom' => 'ba', 'prenom' => 'tapha', 'telephone' => 776948284],
            ['nom' => 'gassama', 'prenom' => 'fatima', 'telephone' => 773643411],
        ];
        DB::table('clients')->insert($clients);
    }
}
