<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class BecarioEntrevistador extends Model
{
    protected $table= 'becarios_entrevistadores';

    public function user()// probar
    {
        //return $this->belongsTo('avaa\User','id');
        return $this->belongsTo('avaa\User','becario_id');
    }

    public function becario()// probar
    {
        return $this->belongsTo('avaa\Becario','becario_id');
    }

    public static function carpetaDocumento()
    {
        return 'documentos/entrevistados/';
    }

    public static function carpetaDocumentoConjunto()
    {
        return 'documentos/entrevistados/conjunto/';
    }
}
