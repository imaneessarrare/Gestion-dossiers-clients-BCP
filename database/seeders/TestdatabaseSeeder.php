<?php
// database/seeders/TestdatabaseSedder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestdatabaseSeeder extends Seeder
{
    
     public function run()
{
    // Client avec revenus en MAD
    Client::create([
        'nom' => 'Alaoui',
        'prenom' => 'Mohamed',
        'revenus_mensuels' => 15000.00, // 15 000 MAD
        // ...
    ]);
    
    // Compte avec solde en MAD
    Compte::create([
        'solde' => 25000.00, // 25 000 MAD
        // ...
    ]);
}  
    }



