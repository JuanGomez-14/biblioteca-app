<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'estado',
    ];

    /**
     * Get the loans for the user.
     */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'usuario_id');
    }

    /**
     * Get the user's full name.
     */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn(string $value, array $attributes) => $attributes['nombre'],
        );
    }
}
