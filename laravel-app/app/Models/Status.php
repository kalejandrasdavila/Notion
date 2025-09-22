<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'notion_id'
    ];

    /**
     * Obtener las solicitudes con este status
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'status', 'name');
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}