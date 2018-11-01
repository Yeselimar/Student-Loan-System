<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class FactLibro extends Model
{
    //
    protected $table='factlibros';

    public function becario()
    {
        return $this->belongsTo('avaa\Becario','becario_id','user_id');
    }
}
