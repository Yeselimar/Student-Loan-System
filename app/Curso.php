<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table='cursos';

    public function becario() //relacion buena
    {
        return $this->belongsTo('avaa\Becario','becario_id');
    }

    public function usuario()//relacion buena
    {
        return $this->belongsTo('avaa\User','becario_id');
    }
    
    public function tipocurso() //relacion buena
    {
        return $this->hasOne('avaa\TipoCurso', 'id','tipocurso_id');
    }

    public function aval()//relacion buena
    {
        return $this->hasOne('avaa\Aval', 'id','aval_id');
    }
    
    public function institucion()//creo que no va
    {
        return $this->belongsTo('avaa\Institucion','institucion_id');
    }

    public function notas()//creo que no va
    {
        return $this->hasMany('avaa\Nota','curso_id');
    }

    public function getIdCurso()
    {
        return $this->nivel." - ".$this->modo." - ".$this->modulo;
    }

    public function getNota()
    {
        return number_format($this->nota, 2, '.', ',');
    }
}
