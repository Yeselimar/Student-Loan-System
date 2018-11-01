<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table='contactos';

    public function fechaCreacion()
    {
        return date("d/m/Y h:i:s a", strtotime($this->created_at));
    }
}
