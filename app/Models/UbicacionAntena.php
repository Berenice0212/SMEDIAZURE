<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionAntena extends Model
{
    protected $table = 'ubicacion_antenas';
    protected $primaryKey = 'id_antena';

    protected $fillable = [
        'id_localidad', 'id_municipio', 'id_estado_energia', 'id_dispositivo', 'ip', 'latitud', 'longitud'
    ];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'id_localidad');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function estadoEnergia()
    {
        return $this->belongsTo(EstadoEnergia::class, 'id_estado_energia');
    }

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class, 'id_dispositivo');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'id_antena', 'id_antena');
    }
}
