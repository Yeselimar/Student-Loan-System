<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class ActividadBecario extends Model
{
    protected $table='actividades_becarios';

    public function aval()//relacion buena
    {
        return $this->hasOne('avaa\Aval', 'id','aval_id');
    }

    public function user()// probar
    {
        return $this->belongsTo('avaa\User','becario_id');
    }
}
