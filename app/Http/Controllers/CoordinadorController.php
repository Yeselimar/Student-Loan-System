<?php

namespace avaa\Http\Controllers;

use avaa\Alerta;
use avaa\Imagen;
use avaa\Mentor;
use avaa\User;
use Illuminate\Http\Request;
use Auth;
use avaa\Solicitud;
use avaa\Becario;
use avaa\Events\SolicitudesAlerts;

class CoordinadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinador');
    }

    //Api
     public function getRelacionBecarioMentor()
    {        
          $collection = collect();
        $becarios= Becario::query()->where('acepto_terminos','=',1)
            ->whereIn('status',['activo','probatorio1','probatorio2'])->get();

             $becarios->each(function ($becarios)
            {
                $becarios->user;
            });
            
            foreach ($becarios as $becario){
                $becarioId = $becario->user_id;
                $becarioName = $becario->user->name . " "  . $becario->user->last_name;
                $mentorId = null;
                $mentorName = null;
                $rowVariant = 'warning';
                $tieneRelacion = false;
                if($becario->mentor_id !== null){
                    $userMentor= User::find($becario->mentor_id);
                    $mentorId = $becario->mentor_id;
                    $mentorName = $userMentor->name . " " . $userMentor->last_name;
                    $rowVariant = 'success';
                    $tieneRelacion = true;
                }
                 $collection->push(array(
                   "becario" => array('becarioId' => $becarioId,
                   'becarioName' => $becarioName),
                   "mentor" => array(
                   'mentorId' => $mentorId,
                   'mentorName' => $mentorName),
                   'tieneRelacion' => $tieneRelacion,
                   '_rowVariant' => $rowVariant

               ));

            }
        
        return $collection;
    }
    public function getBecarios()
    {        
        $becarios= Becario::query()->where('acepto_terminos','=',1)
            ->whereIn('status',['activo','probatorio1','probatorio2'])->get();
             $becarios->each(function ($becarios)
            {
                $becarios->user;

            });
        return $becarios;
    }
    public function getMentores()
    {        
        $mentores= Mentor::query()->where('status','=','activo')->get();
         $mentores->each(function ($mentores)
            {
                $mentores->user;

            });
        return $mentores;
    }
    //Fin API
    public function asignarBecarios()
    {        
        $mentores= Mentor::query()->where('status','=','activo')->get();
        $becarios= Becario::query()->where('acepto_terminos','=',1)
            ->whereIn('status',['activo','probatorio1','probatorio2'])->get();
        return view('sisbeca.mentores.asignarBecarios')->with('mentores',$mentores)->with('becarios',$becarios);
    }
    
    public function asignarMentorBecario(Request $request)
    {
        $becario= $request->get('becarioId');
        $beco= Becario::where("user_id","=",$becario)->first();
        if( $request->get('mentorId') !== null && $request->get('mentorId') !== "null")
        {
            $mentor = $request->get('mentorId');
            $userMentor= User::find($mentor);
            $beco->mentor_id= $mentor;
            $beco->save();
            Alerta::where('status', '=', 'generada')->where('solicitud','=',null)->where('user_id', '=',  $beco->user_id)->delete();
            $alerta = new Alerta();
            $alerta->titulo = 'Nuevo Mentor Asignado';
            $alerta->status='generada';
            $alerta->descripcion = $beco->user->name.' '.$beco->user->last_name.' Se le ha asignado a '.$userMentor->name.' '.$userMentor->last_name.' como Mentor';
            $alerta->user_id= $beco->user_id;
            $alerta->save();
            Alerta::where('status', '=', 'generada')->where('solicitud','=',null)->where('user_id', '=', $mentor)->delete();
            $alerta = new Alerta();
            $alerta->titulo = 'Nuevo(s) Becario(s) Asignado(s)';
            $alerta->status='generada';
            $alerta->descripcion ='Se le ha asignado nuevo(s) becario(s) ';
            $alerta->user_id= $mentor;
            $alerta->save();
            return response()->json(['success'=>'Mentor asignado a becario(s) exitosamente!!']);
        } else{
            $beco->mentor_id = null;//quito la relacion becario mentor
            $beco->save();// guardo
            Alerta::where('status', '=', 'generada')->where('solicitud','=',null)->where('user_id', '=',  $beco->user_id)->delete();
            $alerta = new Alerta();
            $alerta->titulo = 'Sin Mentor Asignado';
            $alerta->status='generada';
            $alerta->descripcion = 'Se le ha quitado la Relación Becario-Mentor Temporalmente, pronto se le asignara un nuevo mentor';
            $alerta->user_id= $beco->user_id;
            $alerta->save();
            return response()->json(['success'=>'Quitada la Relación Becario-Mentor.']);
        }

    }
}
