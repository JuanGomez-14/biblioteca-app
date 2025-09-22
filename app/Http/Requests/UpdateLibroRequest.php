<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|max:255|unique:libros,isbn,' . $this->libro->id,
            'año_publicacion' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'numero_paginas' => 'sometimes|required|integer|min:1',
            'descripcion' => 'nullable|string',
            'stock_disponible' => 'sometimes|required|integer|min:0',
            'autores' => 'sometimes|required|array',
            'autores.*' => 'integer|exists:autores,id',
        ];
    }
}
