<?php

namespace Database\Seeders;

use App\Models\ExampleCRUD;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExampleCRUDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExampleCRUD::factory(5)->create();
    }
}
