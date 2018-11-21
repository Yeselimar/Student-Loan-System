<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;
use DateTime;

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

    public function totalbecarios()
    {
        return $this->becarios->count();
    }

    //verifica que la inscripción se antes de las 24 horas y que esté disponible el curso.
    public function inscribionabierta()
    {
        $fechahoy = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s') );
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $this->fecha);
        $fechaactividad = DateTime::createFromFormat('Y-m-d H:i:s', $fecha->format("Y-m-d").' '.$this->hora_inicio);
        $diferencia = $fechahoy->diff($fechaactividad);
        $dias = $diferencia->format("%R%d");
        $dias = (integer)$dias;
        if($dias>=1 and $this->estaDisponible())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function lapsoparajustificar()
    {
        $actividad = Actividad::find($this->id);
        $fechahoy = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s') );
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $actividad->fecha);
        $fechaactividad = DateTime::createFromFormat('Y-m-d H:i:s', $fecha->format("Y-m-d").' '.$actividad->hora_inicio);
        $f1 =  date('Y-m-d H:i:s', strtotime( $fechaactividad->format("Y-m-d H:i:s").' -1 day'));
        $f2 =  date('Y-m-d H:i:s', strtotime( $fechaactividad->format("Y-m-d H:i:s").' +1 day'));
        $a1 = DateTime::createFromFormat('Y-m-d H:i:s', $f1);
        $a2 = DateTime::createFromFormat('Y-m-d H:i:s', $f2);
        $com1 = $fechahoy >= $a1;
        $com2 = $fechahoy <= $a2;
        if( $com1 and  $com2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function estaDisponible()
    {
        return $this->status=='disponible';
    }

    public function estaSuspendido()
    {
        return $this->status=='suspendido';
    }

    public function estaBloqueado()
    {
        return $this->status=='bloqueado';
    }
}
