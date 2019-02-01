<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;
use DB;
use avaa\ActividadFacilitador;
use avaa\ActividadBecario;
use DateTime;

class Becario extends Model
{
    protected $table= 'becarios';

    public $primaryKey = 'user_id'; //primary key que utiliza la tabla

    public $guarded = ['created_at', 'updated_at'];

    public function fechaEntrevista()
    {
       return date("d/m/Y", strtotime($this->fecha_entrevista));
    }

    public function horaEntrevista()
    {
       return date("h:i:s a", strtotime($this->hora_entrevista));
    }

    public function horaEntrevistaCorta()
    {
       return date("h:i a", strtotime($this->hora_entrevista));
    }

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
        return $query->orwhere('status','=','activo');
    }

    public function scopeInactivos($query)
    {
        return $query->orwhere('status','=','inactivo');
    }

    public function scopeProbatorio1($query)
    {
        return $query->orwhere('status','=','probatorio1');
    }

    public function scopeProbatorio2($query)
    {
        return $query->orwhere('status','=','probatorio2');
    }

    public function scopeTerminosAceptados($query)
    {
        return $query->where('acepto_terminos','=','1');
    }

    public function getTotalPeriodos()
    {
        return $this->periodos->count();
    }

    public function getTotalCVA()
    {
        return $this->cursos->count();
    }

    public function promediotodosperiodos()
    {
        $suma = 0;
        $contador=0;
        foreach($this->periodos as $periodo)
        {
            if($periodo->aval->estatus=="aceptada")
            {
                $contador++;
                $suma = $suma + $periodo->getPromedio();
            }
        }
        if($contador!=0)
        {
            return number_format($suma/$contador, 2, '.', ',');
        }
        return number_format(0, 2, '.', ',');
    }

    public function promediotodoscva()
    {
        $suma = 0;
        $contador=0;
        foreach($this->cursos as $curso)
        {
            if($curso->aval->estatus=="aceptada")
            {
                $contador++;
                $suma = $suma + $curso->nota;
            }
        }
        if($contador!=0)
        {
            return number_format($suma/$contador, 2, '.', ',');
        }
        return number_format(0, 2, '.', ',');
    }

    public function nomBorradores() // ?
    {
        return $this->belongsToMany('avaa\NomBorrador','becarios_nomborradores','becario_id','nomborrador_id','user_id')->withTimestamps();
    }

    public static function getCarpetaImagenes()
    {
        return 'images/becarios/';
    }
    public function imagenes()//relacion becario-imagen
    {
        return $this->hasMany('avaa\Imagen','user_id');
    }

    public static function getCarpetaDocumentos()
    {
        return 'documentos/becarios/';
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

    public function getAceptoTerminos()
    {
        if($this->acepto_terminos=="1")
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    public function getHorasVoluntariados()
    {
        $voluntariados = $this->voluntariados;
        $total = 0;
        foreach($voluntariados as $voluntariado)
        {
            if($voluntariado->aval->estatus=="aceptada")
            {
                $total = $total + $voluntariado->horas;
            }
        }
        $total_a = 0;
        $actividades = $this->actividadesfacilitadas;
        foreach ($actividades as $item)
        {
            $ab = ActividadFacilitador::paraBecario($this->user->id)->paraActividad($item->id)->first();
            $total_a = $total_a + $ab->horas;
        }
        return ($total+$total_a);
    }

    public function getTotalTalleres()
    {
        $actividades = $this->actividades;
        $contador = 0;
        foreach($actividades as $item)
        {
            if($item->tipo=="taller")
            {
                $ab = ActividadBecario::paraBecario($this->user->id)->paraActividad($item->id)->first();
                if($ab->estatus=='asistio')
                {
                    $contador++;
                }
            }
        }
        return $contador;
    }

    public function getTotalChatClubs()
    {
        $actividades = $this->actividades;
        $contador = 0;
        foreach($actividades as $item)
        {
            if($item->tipo=="chat club")
            {
                $ab = ActividadBecario::paraBecario($this->user->id)->paraActividad($item->id)->first();
                if($ab->estatus=='asistio')
                {
                    $contador++;
                }
            }
        }
        return $contador;
    }

    public function getNivelCVA()
    {
        $id=$this->user->id;
        $curso = DB::table('cursos')
            ->where('aval.tipo','=','nota')
            ->where('aval.estatus','=','aceptada')
            ->orderby('cursos.modulo','desc')
            ->join('aval', function ($join) use($id)
        {
          $join->on('cursos.aval_id','=','aval.id')
            ->where('cursos.becario_id','=',$id);
        })->first();
        if(!empty($curso))
        {
            return $curso->modulo.' - '.$curso->modo;
        }
        else
        {
            return "N/A";
        }
    }

    public function getAnhoSemestreCarrera()
    {
        $id=$this->user->id;
        $periodo = DB::table('periodos')
            ->where('aval.tipo','=','constancia')
            ->where('aval.estatus','=','aceptada')
            ->orderby('periodos.numero_periodo','desc')
            ->join('aval', function ($join) use($id)
        {
          $join->on('periodos.aval_id','=','aval.id')
            ->where('periodos.becario_id','=',$id);
        })->first();
        if(!empty($periodo))
        {
            if($this->esSemestral())
                return $periodo->numero_periodo." semestre";
            else
                return $periodo->numero_periodo." año";
        }
        else
        {
            return "N/A";
        }
    }

    public function getfechabienvenida()
    {
        $diff = 0;
        $bienvenida = new DateTime($this->fecha_bienvenida);
        $hoy = new DateTime();
        // Muestra los terminos y condiciones si la fecha de bienvenida es mayor o igual a la actual
        if($this->fecha_bienvenida != null){
            $diff = $hoy->diff($bienvenida);
            if(($diff->invert == 1)){
                return 'true';
            }
            else{
                return 'false';
            }
        }
        else{
            return 'false';
        }
    }

    public function getTiempoParticipaTaller()//no sirve
    {
        $ab = ActividadBecario::paraBecario($this->user->id)->orderby('created_at','desc')->get();
        return $ab->count();
    }
}
