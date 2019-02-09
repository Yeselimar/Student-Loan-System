<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Ticket extends Model
{
    protected $table='tickets';

    public function usuariogenero()// relacion buena
    {
        return $this->belongsTo('avaa\User','usuario_genero_id');
    }

    public function usuariorespuesta()// relacion buena
    {
        return $this->belongsTo('avaa\User','usuario_respuesta_id');
    }

    public static function carpeta()
    {
        return 'images/tickets/';
    }

    public function getNro()
    {
        return '#'.str_pad($this->id, 4, "0", STR_PAD_LEFT);
    }
}