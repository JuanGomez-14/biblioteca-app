<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use App\Http\Requests\StoreLibroRequest;
use App\Http\Requests\UpdateLibroRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Libro::with('autores');

        // Filtros
        if ($request->has('titulo')) {
            $query->where('titulo', 'like', '%' . $request->input('titulo') . '%');
        }

        if ($request->has('autor')) {
            $query->porAutor($request->input('autor'));
        }

        if ($request->has('año')) {
            $query->porAñoPublicacion($request->input('año'));
        }

        $libros = $query->paginate(10);

        return response()->json($libros, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibroRequest $request)
    {
        DB::beginTransaction();
        try {
            $libro = Libro::create($request->validated());
            $libro->autores()->sync($request->autores);
            DB::commit();
            return response()->json($libro->load('autores'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el libro.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = Libro::with('autores')->find($id);

        if (!$libro) {
            return response()->json(['message' => 'Libro no encontrado'], 404);
        }

        return response()->json($libro, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibroRequest $request, Libro $libro)
    {
        DB::beginTransaction();
        try {
            $libro->update($request->validated());
            if ($request->has('autores')) {
                $libro->autores()->sync($request->autores);
            }
            DB::commit();
            return response()->json($libro->load('autores'), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el libro.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro)
    {
        // Esto es un soft delete
        $libro->delete();

        return response()->json(['message' => 'Libro eliminado con éxito'], 200);
    }
}
