<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Mia G.',
            'email' => 'mgouget@protonmail.com',
            'password' => 'vksueoWaz64*',
        ]);

        // User::create([
        //     'name' => 'Véro',
        //     'email' => 'mgouget@protonmail.com',
        //     'password' => 'vksueoWaz64*',
        // ]);
    }
}
