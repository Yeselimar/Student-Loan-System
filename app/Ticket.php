<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Ticket extends Model
{
    protected $table='tickets';

    public function usuariogenero()// probar
    {
        return $this->belongsTo('avaa\User','usuario_genero_id');
    }

    public function usuariorespuesta()// probar
    {
        return $this->belongsTo('avaa\User','usuario_respuesta_id');
    }

}