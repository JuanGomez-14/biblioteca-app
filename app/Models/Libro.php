<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'isbn',
        'año_publicacion',
        'numero_paginas',
        'descripcion',
        'stock_disponible',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'año_publicacion' => 'integer',
        'numero_paginas' => 'integer',
        'stock_disponible' => 'integer',
    ];

    /**
     * The authors that belong to the book.
     */
    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'autor_libro', 'libro_id', 'autor_id')
            ->using(AutorLibro::class)
            ->withPivot('orden_autor');
    }

    /**
     * Get the loans for the book.
     */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'libro_id');
    }

    /**
     * Scope a query to only include books with available stock.
     */
    public function scopeDisponibles(Builder $query): void
    {
        $query->where('stock_disponible', '>', 0);
    }

    /**
     * Scope a query to only include books by a given publication year.
     */
    public function scopePorAñoPublicacion(Builder $query, int $año): void
    {
        $query->where('año_publicacion', $año);
    }

    /**
     * Scope a query to only include books by a given author.
     */
    public function scopePorAutor(Builder $query, string $autorNombre): void
    {
        $query->whereHas('autores', function ($query) use ($autorNombre) {
            $query->where('nombre', 'like', "%{$autorNombre}%")
                ->orWhere('apellido', 'like', "%{$autorNombre}%");
        });
    }
}
