<?php

namespace Database\Seeders;

use App\Models\Films;
use App\Models\Genres;
use Illuminate\Database\Seeder;

class FilmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = Genres::get();
        foreach ($genres as $genre) {
            $count = rand(5, 10);
            for ($i = 0; $i < $count; $i++) {
                $genre->films()->create([
                    'title' => fake()->sentence(3),
                    'is_published' => fake()->boolean(),
                ]);
            }
        }

    }
}
