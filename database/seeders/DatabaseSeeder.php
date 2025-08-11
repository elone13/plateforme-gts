<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Administrateur;
use App\Models\Client;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin manager
        $adminManager = User::create([
            'name' => 'Admin Manager',
            'email' => 'manager@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
        Administrateur::create([
            'user_id' => $adminManager->id,
            'type' => 'manager',
        ]);

        // Create a default admin commercial
        $adminCommercial = User::create([
            'name' => 'Admin Commercial',
            'email' => 'commercial@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
        Administrateur::create([
            'user_id' => $adminCommercial->id,
            'type' => 'commercial',
        ]);

        // Create a test client
        $client = User::create([
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'role' => 'client',
            'password' => bcrypt('password'),
        ]);
        Client::create([
            'user_id' => $client->id,
        ]);
    }
}
