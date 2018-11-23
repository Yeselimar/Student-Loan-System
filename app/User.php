<?php

namespace avaa;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'password','rol','cedula','last_name',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function nombreyapellido()
    {
        return $this->name." ".$this->last_name;
    }

    public function admin()
    {
        return $this->rol==='admin';
    }

    public function esBecario()
    {
        return $this->rol==='becario';
    }
    
    public function esEntrevistador()
    {
        return $this->rol==='entrevistador';
    }

    public function coordinador()//para la relación de 1 a 1 que tiene con la tabla coordinadores (de llegar a tener)
    {
        return $this->hasOne('avaa\Coordinador','user_id');
    }

    public function mentor()//para la relación de 1 a 1 que tiene con la tabla mentores (de llegar a tener)
    {
        return $this->hasOne('avaa\Mentor','user_id');
    }

    //para la relación de 1 a 1 que tiene con la tabla becarios (de llegar a tener)
    public function becario()
    {
        return $this->hasOne('avaa\Becario','user_id');
    }

    //para la relación de 1 a 1 que tiene con la tabla editores (de llegar a tener)
    public function editor()
    {
        return $this->hasOne('avaa\Editor','user_id');
    }

    public function imagenes()
    {
        return $this->hasMany('avaa\Imagen','user_id');
    }

    public function alertas()
    {
        return $this->hasMany('avaa\Alerta','user_id');
    }

    public function solicitudes()
    {
        return $this->hasMany('avaa\Solicitud','user_id');
    }

    public function documentos()
    {
        return $this->hasMany('avaa\Documento','user_id');
    }

    // cuando el rol es entrevistador puedo acceder a mis entrevistados
    public function entrevistados()//probar relacion 
    {
        return $this->belongsToMany('avaa\Becario','becarios_entrevistadores','entrevistador_id','becario_id');
    }


    //scope para buscar los usuario con rol entrevistadores
    public function scopeEntrevistadores($query)
    {
        return $query->where('rol','=','entrevistador');
    }


    public function getFechaNacimiento()
    {
        return date("d/m/Y", strtotime($this->fecha_nacimiento)); 
    }

    public function getEdad()
    {
        return $this->edad.' años';
    }

}
