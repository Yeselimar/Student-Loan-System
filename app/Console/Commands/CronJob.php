<?php

namespace avaa\Console\Commands;

use Illuminate\Console\Command;

use avaa\Alerta;
use avaa\Becario;
use avaa\Nomina;
use avaa\Costo;
use avaa\User;
use avaa\BecarioNomina;
use avaa\FactLibro;
use Illuminate\Support\Facades\DB;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronJob:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Name Change Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //validar que no se haya generado para una fecha
        
         $generar = false;
         $ultimodia = date("Y-m-d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));
         $fechagenerar = strtotime ( '-5 day' , strtotime ( $ultimodia ) ) ;
         $fechagenerar = date ( 'Y-m-d' , $fechagenerar );
         $anho = date ( 'Y' , strtotime($fechagenerar) );
         $mes = date ( 'm' , strtotime($fechagenerar) );
         $nominasaux = Nomina::where('mes',$mes)->where('year',$anho)->get();
 
         if(count($nominasaux)==0)
         {
            $becarios = Becario::where('acepto_terminos','=',1)->where('status','=','activo')->get();
                $costo = Costo::first();

                foreach($becarios as $becario)
                {
                    $nomina = new Nomina();
                    $nomina->retroactivo = $becario->retroactivo;
                    $nomina->datos_nombres= $becario->user->name;
                    $nomina->datos_apellidos = $becario->user->last_name;
                    $nomina->datos_cedula = $becario->user->cedula;
                    $nomina->datos_email = $becario->user->email;
                    $nomina->datos_cuenta = $becario->cuenta_bancaria;
                    $nomina->datos_id= $becario->user_id;
                    $becario->retroactivo=0;//se inicializa el retroactivo en 0 ya que fue cargado para el futuro pago
                    $becario->save();
                    $nomina->sueldo_base = $costo->sueldo_becario;
                    $total = 0;
                    foreach($becario->factlibros as $factlibro)
                    {
                        if($factlibro->status === 'cargada')
                        {
                            //$total = $total + $factlibro->costo; //se comenta porque no se sumara aún
                            $factlibro->status='por procesar';
                            $factlibro->save();
                        }
                    }
                    $nomina->monto_libros = $total;
                    $nomina->total = $nomina->sueldo_base + $nomina->retroactivo + $total;
                    $nomina->mes = $mes;
                    $nomina->year = $anho;
                    $nomina->status = 'pendiente';
                    $nomina->fecha_pago = null;
                    $nomina->fecha_generada = null;
                    $nomina->save();

                    $bn = new BecarioNomina();
                    $bn->user_id = $becario->user_id;//--becario_id
                    $bn->nomina_id = $nomina->id;
                    $bn->save();

                }
                /*Enviar Alerta al directivo */
                //primero veo si la alerta existe
                $alerta= Alerta::query()->where('titulo','=','Nomina(s) pendiente(s) por procesar')->where('tipo','=','nomina')->where('status','=','enviada')->first();
                if(!is_null($alerta))
                {
                    $alerta->leido=false;
                    $alerta->save();
                }
                else
                {
                    $alerta = new Alerta();
                    $alerta->titulo= 'Nomina(s) pendiente(s) por procesar';
                    $alerta->descripcion= 'Tiene Nomina(s) pendiente(s) por procesar, se le aconseja procesar las nominas que tiene pendiente en el Menu de Nominas->Por Procesar';
                    $alerta->user_id=null;
                    $alerta->tipo = 'nomina';
                    $alerta->nivel='alto';
                    $alerta->save();
            }

        $this->info('Nomina created Successfully!');
      }
      else {
        $this->info('Failed Nomina no created!');
      }

    }
}
