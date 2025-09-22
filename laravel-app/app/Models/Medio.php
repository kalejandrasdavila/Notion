<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'notion_id'
    ];

    /**
     * Obtener las solicitudes que usan este medio
     */
    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'solicitud_medios', 'medio_id', 'solicitud_id');
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}