<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PrestamosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $libros = DB::table('libros')->pluck('id')->all();
        $usuarios = DB::table('usuarios')->pluck('id')->all();

        for ($i = 0; $i < 30; $i++) {
            $fecha_prestamo = $faker->dateTimeBetween('-1 year', 'now');
            $fecha_devolucion_estimada = (clone $fecha_prestamo)->modify('+15 days');
            $fecha_devolucion_real = $faker->optional()->dateTimeBetween($fecha_prestamo, 'now');

            DB::table('prestamos')->insert([
                'fecha_prestamo' => $fecha_prestamo,
                'fecha_devolucion_estimada' => $fecha_devolucion_estimada,
                'fecha_devolucion_real' => $fecha_devolucion_real,
                'estado' => $faker->randomElement(['activo', 'devuelto', 'atrasado']),
                'usuario_id' => $faker->randomElement($usuarios),
                'libro_id' => $faker->randomElement($libros),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
