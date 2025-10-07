<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubreporteMedia extends Model
{
    protected $table = 'subreporte_medias';

    protected $fillable = ['subreporte_id','user_id','disk','path','mime','size'];

    public function subreporte(){ return $this->belongsTo(Subreporte::class, 'subreporte_id'); }
    public function user()      { return $this->belongsTo(User::class, 'user_id'); }
}

