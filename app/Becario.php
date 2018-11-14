<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Becario extends Model
{
    protected $table= 'becarios';

    public $primaryKey = 'user_id'; //primary key que utiliza la tabla

    public $guarded = ['created_at', 'updated_at'];
    
    public function user() //Relación uno a uno con USER
    {
        return $this->belongsTo('avaa\User','user_id');
    }

    public function mentor()
    {
        return $this->belongsTo('avaa\Mentor','mentor_id','user_id');
    }

    public function factLibros()//relacion buena
    {
        return $this->hasMany('avaa\FactLibro','becario_id','user_id');
    }

    public function actividades() //relacion buena
    {
        return $this->belongsToMany('avaa\Actividad','actividades_becarios','becario_id','actividad_id','user_id');
    }

    public function actividadesfacilitadas() //relacion  buena
    {
        return $this->belongsToMany('avaa\Actividad','actividades_facilitadores','becario_id','actividad_id','user_id');
    }

    public function cursos()//relacion buena
    {
        return $this->hasMany('avaa\Curso','becario_id','user_id');
    }

    public function voluntariados()//relacion buena
    {
        return $this->hasMany('avaa\Voluntariado','becario_id');
    }

    public function periodos()//relacion buena
    {
        return $this->hasMany('avaa\Periodo','becario_id');
    }

    //busco mis entrevistados a 
    public function entrevistadores()//buena relacion
    {
        return $this->belongsToMany('avaa\User','becarios_entrevistadores','becario_id','entrevistador_id');
    }
    
    public function notas()//creo que no va
    {
        return $this->hasMany('avaa\Nota','becario_id','user_id');
    }
    
    public function nominas()
    {
        return $this->belongsToMany('avaa\Nomina','becarios_nominas','user_id','nomina_id','user_id',null)->withTimestamps();
    }

    public function scopeActivos($query)
    {
        return $query->where('status','=','activo');
    }

    public function nomBorradores() // ?
    {
        return $this->belongsToMany('avaa\NomBorrador','becarios_nomborradores','becario_id','nomborrador_id','user_id')->withTimestamps();
    }
    
    public static function getCarpetaImagenes()
    {
        return '/images/becarios/';
    }

    public static function getCarpetaDocumentos()
    {
        return '/documentos/becarios/';
    }

    public function getTrabaja()
    {
        if($this->trabaja==1)
            return "Si";
        else
            return "No";
    }

    public function getContribuyeIngreso()
    {
        if($this->contribuye_ingreso_familiar==1)
            return "Si";
        else
            return "No";
    }

    public function getContribuyePorcentaje()
    {
        return $this->porcentaje_contribuye_ingreso.' %';
    }

    public function getExperienciaPadre()
    {
        return $this->experiencias_padre.' años';
    }
    
    public function getExperienciaMadre()
    {
        return $this->experiencias_madre.' años';
    }

    public function getInicioUniversidad()
    {
       return date("d/m/Y", strtotime($this->inicio_universidad));
    }

    public function getHablaOtroIdioma()
    {
        if($this->habla_otro_idioma==1)
            return "Si";
        else
            return "No";
    }

    public function esAnual()
    {
        return $this->regimen=="anual";
    }

    public function esSemestral()
    {
        return $this->regimen=="semestral";
    }

    
}
