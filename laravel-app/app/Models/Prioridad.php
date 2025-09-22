<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'notion_id',
        'order'
    ];

    /**
     * Obtener las solicitudes con esta prioridad
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'prioridad', 'name');
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Scope para ordenar por prioridad
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}