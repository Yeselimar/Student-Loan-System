<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Entrevistador extends Model
{
	protected $table= 'entrevistadores';

	public function becarios()//relacion buena
    {
        return $this->belongsToMany('avaa\Becario','becarios_entrevistadores','entrevistador_id','becario_id');
    }
}
