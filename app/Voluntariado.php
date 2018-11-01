<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Voluntariado extends Model
{
    protected $table= 'voluntariados';

    public function becario()//relación buena
    {
        return $this->belongsTo('avaa\Becario','becario_id');
    }

    public function aval()//relación buena
    {
        return $this->hasOne('avaa\Aval', 'id','aval_id');
    }

    public function getFecha()
    {
        return date("d/m/Y", strtotime($this->fecha));
    }
}
