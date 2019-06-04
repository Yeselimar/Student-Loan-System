<?php

namespace avaa;

use Illuminate\Database\Eloquent\Model;

class Estipendio extends Model
{
    protected $table='estipendios';

    protected $fillable = [
        'estipendio', 'mes', 'anio'
    ];

    public function getAnio()
    {
        return $this->anio;
    }
   public static function getEstipendioActual($mes, $anio)
    {
        return $this->where('mes','LIKE',"%$mes%")->where('anio','LIKE',"%$anio%");

    }
    public static function getMes($mes)
    {
        switch ($mes) {
            case 1:
                return 'Enero';
                break;
            case 2:
                return 'Febrero';
                break;
            case 3:
                return 'Marzo';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Mayo';
                break;
            case 6:
                return 'Junio';
                break;
            case 7:
                return 'Julio';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Septiembre';
                break;
            case 10:
                return 'Octubre';
                break;
            case 11:
                return 'Noviembre';
                break;
            case 12:
                return 'Diciembre';
                break;
        }
    }
}
