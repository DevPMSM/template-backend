<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Secti',
            'email' => 'secti@gmail.com',
            'role' => User::ADMIN,
            'password' => env('ADMIN_DEFAULT_PASSWORD'),
            'image' => '/images/logo-pref.png',
        ]);
    }
}
