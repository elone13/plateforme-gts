<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Administrateur;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing users
        User::truncate();
        Administrateur::truncate();
        Client::truncate();

        // Create Manager
        $manager = User::create([
            'name' => 'Manager Test',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        Administrateur::create([
            'user_id' => $manager->id,
            'type' => 'manager',
        ]);

        // Create Commercial
        $commercial = User::create([
            'name' => 'Commercial Test',
            'email' => 'commercial@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        Administrateur::create([
            'user_id' => $commercial->id,
            'type' => 'commercial',
        ]);

        // Create Client
        $client = User::create([
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);
        
        Client::create([
            'user_id' => $client->id,
        ]);

        echo "Users created successfully!\n";
        echo "Manager: manager@example.com / password\n";
        echo "Commercial: commercial@example.com / password\n";
        echo "Client: client@example.com / password\n";
    }
}
