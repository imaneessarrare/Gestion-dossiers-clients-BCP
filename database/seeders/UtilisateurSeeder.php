<?php
// database/seeders/UtilisateurSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        // Au lieu de truncate, on vérifie si l'utilisateur existe déjà
        // et on insère seulement s'il n'existe pas
        
        // Administrateur
        if (!DB::table('utilisateurs')->where('email', 'admin@banque.com')->exists()) {
            DB::table('utilisateurs')->insert([
                'login' => 'admin',
                'nom' => 'Administrateur',
                'email' => 'admin@banque.com',
                'mot_de_passe_hash' => Hash::make('admin123'),
                'role' => 'admin',
                'statut' => 'actif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info('Administrateur créé.');
        } else {
            $this->command->info('Administrateur existe déjà.');
        }

        // Employé
        if (!DB::table('utilisateurs')->where('email', 'jean.dupont@banque.com')->exists()) {
            DB::table('utilisateurs')->insert([
                'login' => 'employe1',
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@banque.com',
                'mot_de_passe_hash' => Hash::make('employe123'),
                'role' => 'employe',
                'statut' => 'actif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info('Employé créé.');
        } else {
            $this->command->info('Employé existe déjà.');
        }

        // Superviseur
        if (!DB::table('utilisateurs')->where('email', 'pierre.martin@banque.com')->exists()) {
            DB::table('utilisateurs')->insert([
                'login' => 'superviseur1',
                'nom' => 'Pierre Martin',
                'email' => 'pierre.martin@banque.com',
                'mot_de_passe_hash' => Hash::make('superviseur123'),
                'role' => 'superviseur',
                'statut' => 'actif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info('Superviseur créé.');
        } else {
            $this->command->info('Superviseur existe déjà.');
        }
    }
}