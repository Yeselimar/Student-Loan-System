<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class ActividadFacilitador extends Model
{
    protected $table='actividades_facilitadores';

    public function becario()//relacion buena
    {
        return $this->hasOne('avaa\Becario', 'user_id','becario_id');
    }

    public function user()// probar
    {
        return $this->belongsTo('avaa\User','becario_id');
    }
}
