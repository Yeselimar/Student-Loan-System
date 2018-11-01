<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table='actividades';

    public function becarios()//relacion buena
    {
        return $this->belongsToMany('avaa\Becario','actividades_becarios','actividad_id','becario_id');
    }

    public function facilitadores()//relacion buena
    {
        return $this->hasMany('avaa\ActividadFacilitador','actividad_id');
    }
    
    public function editor()// (?)no va?
    {
        return $this->belongsTo('avaa\Editor','editor_id','user_id');
    }   
}
