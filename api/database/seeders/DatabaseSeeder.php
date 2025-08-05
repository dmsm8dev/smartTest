<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\GenresFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.ts',
        ]);

        $this->call([
            GenresSeeder::class,
            FilmsSeeder::class
        ]);

        User::factory(20)->create();
    }
}
