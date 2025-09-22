<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Prestamo;
use App\Models\Libro;

class GenerarReporteBiblioteca extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reporte:biblioteca';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un reporte de la biblioteca y actualiza préstamos vencidos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Actualizando préstamos vencidos...');
        $this->actualizarPrestamosVencidos();
        $this->info('Préstamos actualizados. Generando reportes...');

        $this->newLine();
        $this->reporteLibrosMasPrestados();

        $this->newLine();
        $this->reporteUsuariosConPrestamosVencidos();

        $this->newLine();
        $this->reporteLibrosSinStock();
    }

    /**
     * Marca automáticamente los préstamos vencidos.
     */
    protected function actualizarPrestamosVencidos()
    {
        $prestamosVencidos = Prestamo::where('estado', 'activo')
            ->where('fecha_devolucion_estimada', '<', now())
            ->get();

        foreach ($prestamosVencidos as $prestamo) {
            $prestamo->update(['estado' => 'atrasado']);
        }

        $this->info('Se han marcado ' . $prestamosVencidos->count() . ' préstamos como atrasados.');
    }

    /**
     * Reporte de los libros más prestados.
     */
    protected function reporteLibrosMasPrestados()
    {
        $librosMasPrestados = DB::table('prestamos')
            ->select('libros.titulo', DB::raw('count(*) as total_prestamos'))
            ->join('libros', 'prestamos.libro_id', '=', 'libros.id')
            ->groupBy('libros.titulo')
            ->orderBy('total_prestamos', 'desc')
            ->limit(10)
            ->get();

        $this->info('--- Reporte: Libros más prestados ---');
        $this->table(['Título', 'Total de Préstamos'], $librosMasPrestados->map(function ($libro) {
            return [$libro->titulo, $libro->total_prestamos];
        }));
    }

    /**
     * Reporte de usuarios con préstamos vencidos.
     */
    protected function reporteUsuariosConPrestamosVencidos()
    {
        $usuariosVencidos = Prestamo::with('usuario')
            ->where('estado', 'atrasado')
            ->groupBy('usuario_id')
            ->select('usuario_id')
            ->get()
            ->map(function ($prestamo) {
                return [$prestamo->usuario->nombre, $prestamo->usuario->email];
            });

        $this->info('--- Reporte: Usuarios con préstamos vencidos ---');
        $this->table(['Nombre de Usuario', 'Email'], $usuariosVencidos);
    }

    /**
     * Reporte de libros sin stock.
     */
    protected function reporteLibrosSinStock()
    {
        $librosSinStock = Libro::where('stock_disponible', 0)->get();

        $this->info('--- Reporte: Libros sin stock ---');
        $this->table(['ID', 'Título'], $librosSinStock->map(function ($libro) {
            return [$libro->id, $libro->titulo];
        }));
    }
}
