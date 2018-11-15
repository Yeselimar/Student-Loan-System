<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Alerta;
use avaa\Events\SolicitudesAlerts;
use avaa\Solicitud;
use Auth;
use DateTime;
use Timestamp;

class CompartidoMentorBecarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('compartido_mentor_becario');
    }

    public function listarsolicitudes()
    {
        $solicitudes = Solicitud::query()->where('user_id','=',Auth::user()->id)->get();
        return view('sisbeca.solicitudes.listar')->with(compact('solicitudes'));
    }
    
    public function solicitud()
    {
        $id_user=Auth::user()->id;
        $solicitudes = Solicitud::query()->where('user_id','=',$id_user)->get();
        return view('sisbeca.solicitudes.rlsolicitud')->with('solicitudes',$solicitudes);
    }

    public function crearsolicitud()
    {
        $model = "crear";
        return view('sisbeca.solicitudes.model')->with(compact('model'));
    }

    public  function solicitudStore(Request $request)
    {

        $status=null;
        if(Auth::user()->rol==='becario')
        {
            $status=Auth::user()->becario->status;
        }
        else
        {
            $status=Auth::user()->mentor->status;
        }

        if(($status!=='inactivo') &&($request->get('titulo')==='reincorporacion'))
        {
            flash('Disculpe, no puede solicitar reincorporacion ya que actualmente se encuentra en el programa','danger')->important();
            return redirect()->route('solicitud.listar');
        }
        $controlQuery = Solicitud::query()->select('titulo')->where('user_id','=',Auth::user()->id)->where('status','=','enviada')
            ->whereIn('titulo',['desincorporacion temporal','desincorporacion definitiva','reincorporacion'])->get();
        $control= $controlQuery->pluck('titulo')->toArray();

        $clave = array_search( $request->get('titulo'),$control); // me devuelve falso si  no encontro elemento

        if(!is_bool($clave))
        {
            flash('Disculpe, actualmente usted ya hizo una solicitud tipo '.$request->get('titulo').' la cual se encuentra en estado enviada','danger')->important();
            return redirect()->route('solicitud.listar');
        }

        $solicitud= new Solicitud($request->all());

        if($solicitud->titulo==='desincorporacion definitiva')
        {
          $solicitud->fecha_desincorporacion=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_desincorporacion').' 00:00:00');
        }
        else
        {
            if($solicitud->titulo==='desincorporacion temporal')
            {
                $solicitud->fecha_inactividad=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_inactividad').' 00:00:00');
            }
        }

        $solicitud->user_id=Auth::user()->id;

        if($solicitud->save())
        {
            event(new SolicitudesAlerts($solicitud));
            flash('Su solicitud fue enviada exitosamente','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al enviar solicitud','danger')->important();
        }
        return redirect()->route('solicitud.listar');

    }

    public function solicitudEdit($id)
    {
        $solicitud = Solicitud::find($id);

        if(is_null($solicitud)|| ($solicitud->user_id!=Auth::user()->id))
        {
            flash('El archivo solicitado no ha sido encontrado','danger')->important();
            return back();
        }

        $alerta= Alerta::query()->select()->where('solicitud','=',$id)->where('status','=','generada')->first();

        if(!is_null($alerta))
        {
            $alerta->leido = true;

            $alerta->save();
        }
        return view('sisbeca.solicitudes.solicitudEdit')->with('solicitud',$solicitud);
    }

    public function SolicitudUpdate(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);

        $solicitud->fill($request->all());

        if($solicitud->titulo==='desincorporacion definitiva')
        {
            $solicitud->fecha_desincorporacion=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_desincorporacion').' 00:00:00');
        }
        else
        {
            if($solicitud->titulo==='desincorporacion temporal')
            {
                $solicitud->fecha_inactividad=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_inactividad').' 00:00:00');
            }
        }


        if(($solicitud->user_id==Auth::user()->id) &&($solicitud->status==='enviada') && $solicitud->save())
        {
            Alerta::where('solicitud', $id)->delete();
            event(new SolicitudesAlerts($solicitud));
            flash('Su solicitud fue actualizada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al actualizar su solicitud.')->error()->important();
        }

        return  redirect()->route('solicitud.listar');

    }

    public function solicitudDestroy($id)
    {
        $solicitud = Solicitud::find($id);
        if(is_null($solicitud))
        {
            flash('El archivo solicitado no ha sido encontrado.')->error()->important();
            return back();
        }

        if(($solicitud->user_id==Auth::user()->id) &&($solicitud->status==='enviada') && $solicitud->delete())
        {
            Alerta::where('solicitud', $id)->delete();
            flash('Su solicitud ha sido eliminada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al eliminar solicitud.')->error()->important();
        }

        return  redirect()->route('solicitud.listar');
    }
}
