<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiar las tablas para evitar duplicados si se corre varias veces
        DB::table('prestamos')->truncate();
        DB::table('autor_libro')->truncate();
        DB::table('libros')->truncate();
        DB::table('autores')->truncate();
        DB::table('usuarios')->truncate();

        $this->call([
            UsuariosTableSeeder::class,
            AutoresTableSeeder::class,
            LibrosTableSeeder::class,
            PrestamosTableSeeder::class,
        ]);

        // Seeder para la tabla pivote 'autor_libro'
        $libros = DB::table('libros')->pluck('id');
        $autores = DB::table('autores')->pluck('id');

        foreach ($libros as $libro_id) {
            $autoresAleatorios = $autores->random(rand(1, 3));
            foreach ($autoresAleatorios as $autor_id) {
                DB::table('autor_libro')->insert([
                    'autor_id' => $autor_id,
                    'libro_id' => $libro_id,
                    'orden_autor' => rand(1, 3),
                ]);
            }
        }
    }
}
