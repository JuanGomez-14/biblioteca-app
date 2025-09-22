<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Libro;
use App\Models\Usuario;

class StorePrestamoRequest extends FormRequest
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
            'usuario_id' => [
                'required',
                'integer',
                // Validar que el usuario exista y no tenga más de 3 préstamos activos
                Rule::exists('usuarios', 'id')->where(function ($query) {
                    $usuario = Usuario::find($this->usuario_id);
                    if ($usuario && $usuario->prestamos()->where('estado', 'activo')->count() >= 3) {
                        return $query->where('id', null); // Fallar la validación si el usuario tiene 3 préstamos
                    }
                })
            ],
            'libro_id' => [
                'required',
                'integer',
                // Validar que el libro exista y tenga stock disponible
                Rule::exists('libros', 'id')->where(function ($query) {
                    $query->where('stock_disponible', '>', 0);
                }),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'usuario_id.exists' => 'El usuario no puede tener más de 3 préstamos activos.',
            'libro_id.exists' => 'El libro no tiene stock disponible para prestar.',
        ];
    }
}
