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
        $this->call([
            KibSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin Simaset',
            'email' => 'admin@simaset.com',
            'password' => bcrypt('password'),
        ]);
    }
}
