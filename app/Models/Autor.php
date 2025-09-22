<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'nacionalidad',
        'biografia',
    ];

    /**
     * The books that belong to the author.
     */
    public function libros(): BelongsToMany
    {
        return $this->belongsToMany(Libro::class, 'autor_libro', 'autor_id', 'libro_id')
            ->using(AutorLibro::class)
            ->withPivot('orden_autor');
    }

    /**
     * Get the full name of the author.
     */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn(string $value, array $attributes) => $attributes['nombre'] . ' ' . $attributes['apellido'],
        );
    }
}
