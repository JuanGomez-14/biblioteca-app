<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AutoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 10; $i++) {
            DB::table('autores')->insert([
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'fecha_nacimiento' => $faker->date('Y-m-d', '2000-01-01'),
                'nacionalidad' => $faker->country,
                'biografia' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
