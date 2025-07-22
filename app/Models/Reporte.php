<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';

    protected $fillable = [
        'creado_por',
        'tecnico_id',
        'ip_antena',
        'id_antena',
        'id_localidad',
        'id_municipio',
        'latitud',
        'longitud',
        'fecha_fallo',
        'fecha_finalizacion',
        'estado',
        'descripcion_admin',
        'descripcion_tecnico',
        'solucion',
    ];

    // Relaciones
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function antena()
    {
        return $this->belongsTo(UbicacionAntena::class, 'id_antena');
    }

    public function ubicacionAntena()
    {
        return $this->belongsTo(\App\Models\UbicacionAntena::class, 'id_antena', 'id_antena');
    }
}
