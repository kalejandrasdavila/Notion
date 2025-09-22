<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'status',
        'tipo',
        'solicitante',
        'indicaciones',
        'fecha_planeada',
        'prioridad',
        'medio',
        'notion_page_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha_planeada' => 'date',
        'medio' => 'array',
    ];

    /**
     * Obtener el status de la solicitud
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'name');
    }

    /**
     * Obtener el tipo de la solicitud
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo', 'name');
    }

    /**
     * Obtener la prioridad de la solicitud
     */
    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'prioridad', 'name');
    }

    /**
     * Obtener los medios de la solicitud
     */
    public function medios()
    {
        return $this->belongsToMany(Medio::class, 'solicitud_medios', 'solicitud_id', 'medio_id');
    }

    /**
     * Scope para filtrar por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeByTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para filtrar por prioridad
     */
    public function scopeByPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopeByFecha($query, $fecha)
    {
        return $query->whereDate('fecha_planeada', $fecha);
    }

    /**
     * Scope para filtrar por solicitante
     */
    public function scopeBySolicitante($query, $solicitante)
    {
        return $query->where('solicitante', 'like', '%' . $solicitante . '%');
    }
}