<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LibrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 15; $i++) {
            DB::table('libros')->insert([
                'titulo' => $faker->sentence(3),
                'isbn' => $faker->isbn13,
                'año_publicacion' => $faker->year(),
                'numero_paginas' => $faker->numberBetween(50, 1000),
                'descripcion' => $faker->paragraph,
                'stock_disponible' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
