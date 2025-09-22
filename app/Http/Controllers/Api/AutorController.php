<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Autor $autor)
    {
        if ($autor->libros()->count() > 0) {
            return response()->json(['message' => 'No se puede eliminar un autor con libros asociados.'], 409);
        }

        $autor->delete();
        return response()->json(['message' => 'Autor eliminado con éxito.'], 200);
    }
}
