<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subreporte extends Model
{
    protected $table = 'subreportes';

    protected $fillable = [
        'reporte_principal_id','tecnico_id','descripcion_tecnico',
        'solucion','fecha_visita','estado_after'
    ];

    public function reportePrincipal(){ return $this->belongsTo(ReportePrincipal::class, 'reporte_principal_id'); }
    public function tecnico()        { return $this->belongsTo(User::class, 'tecnico_id'); }
    public function medias()         { return $this->hasMany(SubreporteMedia::class, 'subreporte_id'); }
}

