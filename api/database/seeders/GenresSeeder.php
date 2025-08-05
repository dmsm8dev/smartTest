<?php

namespace Database\Seeders;


use App\Models\Genres;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genres::factory(rand(5, 7))->create();
    }
}
