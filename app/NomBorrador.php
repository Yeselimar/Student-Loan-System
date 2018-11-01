<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class NomBorrador extends Model
{
    protected $table='nomborradores';

    public function becarios()
    {
        return $this->belongsToMany('avaa\Becario','becarios_nomborradores','nomborrador_id','becario_id','user_id')->withTimestamps();
    }
}
