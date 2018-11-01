<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table= 'alertas';

    public function user()
    {
        return $this->belongsTo('avaa\User','user_id');
    }
}
