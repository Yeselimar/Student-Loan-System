<?php

namespace avaa\Http\Controllers;

use avaa\Coordinador;
use avaa\Desincorporacion;
use avaa\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use avaa\Becario;
use avaa\Mentor;
use avaa\Alerta;
use avaa\Solicitud;
use avaa\Documento;
use avaa\Imagen;
use avaa\Events\SolicitudesAlerts;
use Illuminate\Support\Facades\Auth;

class CompartidoDirecCoordController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('compartido_direc_coord');
    }

    public function listarBecarios()
    {
        if( Auth::user()->rol==='directivo' or Auth::user()->rol==='coordinador')
        {
            $becarios = Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactivo'])->get();        
        }

        if($becarios->count()>0)
        {
            $becarios->each(function ($becarios) {
                if($becarios->mentor_id!=null)
                {
                    $becarios->mentor->user;
                }

            });
        }
        else
        {
            flash('Aún no Existen Becarios Registrados','danger');
        }

        return view('sisbeca.becarios.listar')->with('becarios',$becarios);
    }

    public function listarMentores()
    {
        $mentores = Mentor::all();

        if($mentores->count()>0) {

            $mentores->each(function ($mentores) {
                $mentores->becarios;

                foreach ($mentores->becarios as $becario) {

                    $becario->user;
                }
            });

        }
        else
        {
            flash('Aún no Existen Mentores Registrados','danger');
        }

        return view('sisbeca.mentores.listar')->with('mentores',$mentores);
    }


    public function listarSolicitudes()
    {

        $becariosAsignados = Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactivo'])->get();   
        $listaBecariosA=$becariosAsignados->pluck('user_id')->toArray();


        if(Auth::user()->rol==='directivo' or Auth::user()->rol==='coordinador')
        {
            $mentoresNuevos= Mentor::all();


            $collection = collect();
            foreach ($mentoresNuevos as $mentor) {

                if($mentor->becarios()->count()==0)
                {
                    $collection->push($mentor);
                }

            }
        }
        else
        {
            $collection = collect();
            foreach ($becariosAsignados as $beca) {

                $collection->push($beca->mentor);
            }

        }
        $listMentoresA = $collection->pluck('user_id')->toArray();

        $mentoresAsignados = Mentor::query()->whereIn('user_id', $listMentoresA)->get();
        $listaMentoresA = $mentoresAsignados->pluck('user_id')->toArray();

        $solicitudes = Solicitud::query()->whereIn('user_id',$listaBecariosA)->orWhereIn('user_id',$listaMentoresA)->get();
        return view('sisbeca.gestionSolicitudes.listarSolicitudes')->with('solicitudes',$solicitudes);
    }

    public function revisarSolicitud($id)
    {
        $solicitudes = Solicitud::find($id);

        $alerta= Alerta::query()->select()->where('solicitud','=',$id)->first();

        $alerta->leido=true;
        $alerta->save();

        $img_perfil_postulante=Imagen::query()->where('user_id','=',$solicitudes->user_id)->where('titulo','=','img_perfil')->get();

        return view('sisbeca.gestionSolicitudes.procesarSolicitud')->with('solicitud',$solicitudes)->with('img_perfil_postulante',$img_perfil_postulante);
    }

    public function gestionSolicitudUpdate(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);
        if(Auth::user()->rol==='directivo' or Auth::user()->rol==='coordinador')
        {
            $becariosAsignados = Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactvo'])->get();
            $listaBecariosA = $becariosAsignados->pluck('user_id')->toArray();
            $clave = array_search($solicitud->user_id, $listaBecariosA); // me devuelve falso si  no encontro elemento
            $mentoresNuevos= Mentor::all();
            $collection = collect();
            foreach ($mentoresNuevos as $mentor)
            {
                if($mentor->becarios()->count()==0)
                {
                    $collection->push($mentor);
                }
            }
        }
        
        $listMentoresA = $collection->pluck('user_id')->toArray();
        $mentoresAsignados = Mentor::query()->whereIn('user_id', $listMentoresA)->get();
        $listaMentoresA = $mentoresAsignados->pluck('user_id')->toArray();
        $clave1 = array_search($solicitud->user_id, $listaMentoresA); // me devuelve falso si  no encontro elemento
        if (is_bool($clave) && is_bool($clave1))
        {
            flash('Error el archivo solicitado no existe**', 'danger')->important();
            return back();
        }

        if($request->get('valor')==='1')
        {
            flash('La solicitud de '.$solicitud->user->name.' ha sido aprobada exitosamente','success')->important();

            if($solicitud->user->rol==='becario')
                $instancia= Becario::query()->select()->where('user_id','=',$solicitud->user_id)->first();
            else
            {
                $instancia= Mentor::query()->select()->where('user_id','=',$solicitud->user_id)->first();
            }

            if($solicitud->titulo==='desincorporacion temporal')
            {
                $instancia->status='inactivo';
                if($solicitud->user->rol==='becario')
                {
                    $instancia->fecha_inactivo= date('Y-m-d');
                    $instancia->observacion_inactivo= $solicitud->descripcion;
                }
                else
                {
                    $becariosT= Becario::query()->where('mentor_id','=',$instancia->user_id)->get();
                    foreach ($becariosT as $becario)
                    {
                        //$becario->mentor_id= Mentor::first()->user_id;
                        $becario->save();
                    }
                }
                flash($instancia->user->name.' Ha sido desincorporado temporalmente en el sistema','info')->important();
            }
            else
            {
                if($solicitud->titulo==='desincorporacion definitiva')
                {
                    $instancia->status='desincorporado';
                    if($solicitud->user->rol==='becario')
                    {
                        $instancia->mentor_id = null;
                    }
                    else
                    {
                        $becariosT= Becario::query()->where('mentor_id','=',$instancia->user_id)->get();

                        foreach ($becariosT as $becario)
                        {
                            $becario->mentor_id= null;
                            $becario->save();
                        }
                    }
                    $desincorporacion= new Desincorporacion();

                    $desincorporacion->tipo='solicitud';
                    $desincorporacion->observacion= 'El motivo de la gestion de desincorporacion radica en que el usuario: '.$instancia->user->name.' '.$instancia->user->last_name.' solicito dicha desincorporación la cual fue evaluada y aceptada por el consejo.';
                    $desincorporacion->user_id= $instancia->user->id;
                    $desincorporacion->datos_nombres= $instancia->user->name;
                    $desincorporacion->datos_apellidos= $instancia->user->last_name;
                    $desincorporacion->datos_email= $instancia->user->email;
                    $desincorporacion->datos_cedula= $instancia->user->cedula;
                    $desincorporacion->datos_rol= $instancia->user->rol;
                    $desincorporacion->gestionada_por= Auth::user()->id;
                    $desincorporacion->fecha_gestionada= date('Y-m-d');
                    $desincorporacion->save();

                    /*Enviar Alerta al directivo */

                    //primero veo si la alerta existe
                    /*
                    $alerta= Alerta::query()->where('user_id','=', Coordinador::first()->user_id)->where('titulo','=','Desincorporacion(es) pendiente(s) por procesar')->where('status','=','enviada')->first();

                    if(!is_null($alerta))
                    {
                        $alerta->leido=false;
                        $alerta->save();
                    }
                    else
                    {
                        $alerta = new  Alerta();

                        $alerta->titulo= 'Desincorporacion(es) pendiente(s) por procesar';
                        $alerta->Descripcion= 'Tiene Desincorporacion(es) pendiente(s) por procesar, se le aconseja procesar las desincorporaciones que tiene pendiente en el Menu de Desincorporaciones->Desincorporacion';
                        $alerta->user_id= Coordinador::first()->user_id;
                        $alerta->nivel='alto';
                        $alerta->save();
                    }
                    flash($instancia->user->name.' Ha sido enviado para desincorporacion definitiva en el sistema','info')->important();
                    */

                }
                else
                {
                    if($solicitud->titulo==='reincorporacion')
                    {
                        $instancia->status='activo';
                        flash($instancia->user->name.' Ha sido Reincorporado nuevamente al Programa AVAA','info')->important();

                    }
                }

            }
            $solicitud->status='aceptada';
            $instancia->save();

        }
        else
        {
            $solicitud->status='rechazada';
            flash('La solicitud de '.$solicitud->user->name.' ha sido rechazada','info')->important();
        }


        $solicitud->usuario_respuesta= Auth::user()->id;
        $solicitud->save();
        event(new SolicitudesAlerts($solicitud));

        return  redirect()->route('gestionSolicitudes.listar');

    }

    public function verPerfilMentor($id){
        $mentor= Mentor::find($id);

        $img_perfil=Imagen::query()->where('user_id','=',$mentor->user_id)->where('titulo','=','img_perfil')->get();
        $documento = Documento::query()->where('user_id', '=', $mentor->user_id)->where('titulo', '=', 'hoja_vida')->first();

        return view('sisbeca.mentores.perfilMentor')->with('mentor',$mentor)->with('img_perfil',$img_perfil)->with('documento',$documento);
    }

    public function formularioReporteSolicitudes()
    {

        $users= User::query()->whereIn('rol',['mentor','becario'])->get();
        return view('sisbeca.solicitudes.formularioReporteSolicitudes')->with('users',$users);
    }
    public function solicitudespdf(Request $request)
    {
        $data= explode ('/',$request->get('fechaDesde'));
        $fechaDesde= Carbon::createFromDate($data[2],$data[1],$data[0])->format('Y-m-d');
        $data= explode ('/',$request->get('fechaHasta'));
        $fechaHasta= Carbon::createFromDate($data[2],$data[1],$data[0])->format('Y-m-d');

        $user= $request->get('user_id');

        if($user==0)
        {
            $solicitudes = Solicitud::query()->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();

        }else {
            $solicitudes = Solicitud::query()->where('user_id', '=', $user)->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();
        }

        if($solicitudes->count()==0){
            flash('No existe data con los parametros establecidos para generar el reporte','danger')->important();
            return redirect()->route('formularioReporte.solicitudes');
        }
        else
        {
            flash('Reporte ejecutado Exitosamente haga click en el boton generar pdf para visualizarlo','success')->important();

        }

        $users= User::query()->whereIn('rol',['mentor','becario'])->get();
        return view('sisbeca.solicitudes.formularioReporteSolicitudes')->with('users',$users)->with('user_id',$user)->with('fechaDesde',$fechaDesde)->with('fechaHasta',$fechaHasta);

    }

    public function pdfSolicitud($fechaDesde,$fechaHasta,$user_id){
        if($user_id==0)
        {
            $solicitudes = Solicitud::query()->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();

        }else {
            $solicitudes = Solicitud::query()->where('user_id', '=', $user_id)->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();
        }

        if($solicitudes->count()==0){
            flash('No existe data con los parametros establecidos para generar el reporte','danger')->important();
            return redirect()->route('formularioReporte.solicitudes');
        }

        switch (date('m')) {
            case 1:
                $mes= 'Enero';
                break;
            case 2:
                $mes=  'Febrero';
                break;
            case 3:
                $mes= 'Marzo';
                break;
            case 4:
                $mes=  'Abril';
                break;
            case 5:
                $mes=  'Mayo';
                break;
            case 6:
                $mes=  'Junio';
                break;
            case 7:
                $mes=  'Julio';
                break;
            case 8:
                $mes=  'Agosto';
                break;
            case 9:
                $mes=  'Septiembre';
                break;
            case 10:
                $mes=  'Octubre';
                break;
            case 11:
                $mes=  'Noviembre';
                break;
            case 12:
                $mes=  'Diciembre';
                break;
        }

        $pdf = PDF::loadView('sisbeca.solicitudes.reporteDeSolicitudes', compact('solicitudes','mes','fechaDesde','fechaHasta'));

        return $pdf->stream('reporteDeSolicitudes.pdf', 'PDF xasa');
    }
}
