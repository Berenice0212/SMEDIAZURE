<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportePrincipal extends Model
{
    protected $table = 'reporte_principal';

    protected $fillable = [
        'creado_por', 'tecnico_id', 'id_antena', 'ip_antena',
        'id_localidad', 'id_municipio', 'latitud', 'longitud',
        'fecha_fallo', 'fecha_finalizacion', 'estado', 'descripcion_admin'
    ];

    public function creador()    { return $this->belongsTo(User::class, 'creado_por'); }
    public function tecnico()    { return $this->belongsTo(User::class, 'tecnico_id'); }
    public function antena()     { return $this->belongsTo(UbicacionAntena::class, 'id_antena', 'id_antena'); }
    public function subreportes(){ return $this->hasMany(Subreporte::class, 'reporte_principal_id'); }
}
