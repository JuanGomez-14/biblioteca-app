<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Http\Requests\StorePrestamoRequest;
use App\Http\Requests\DevolverPrestamoRequest;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamos = Prestamo::with(['libro', 'usuario'])->paginate(10);
        return response()->json($prestamos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrestamoRequest $request)
    {
        $prestamo = Prestamo::create([
            'fecha_prestamo' => now(),
            'fecha_devolucion_estimada' => now()->addDays(15),
            'estado' => 'activo',
            'usuario_id' => $request->usuario_id,
            'libro_id' => $request->libro_id,
        ]);
        return response()->json($prestamo, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function devolver(DevolverPrestamoRequest $request, Prestamo $prestamo)
    {
        $prestamo->update([
            'fecha_devolucion_real' => now(),
            'estado' => 'devuelto',
        ]);
        return response()->json($prestamo, 200);
    }
}
