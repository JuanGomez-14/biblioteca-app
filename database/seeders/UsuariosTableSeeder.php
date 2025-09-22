<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 20; $i++) {
            DB::table('usuarios')->insert([
                'nombre' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'telefono' => $faker->numerify('##########'),
                'estado' => $faker->randomElement(['activo', 'inactivo']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
