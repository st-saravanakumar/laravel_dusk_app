<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the UserSeeder and ProductSeeder
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
