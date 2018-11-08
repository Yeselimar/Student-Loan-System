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

    public function solicitud()
    {
        $id_user=Auth::user()->id;
        $solicitudes = Solicitud::query()->where('user_id','=',$id_user)->get();
        return view('sisbeca.solicitudes.rlsolicitud')->with('solicitudes',$solicitudes);
    }

    public  function solicitudStore(Request $request){

        $status=null;
        if(Auth::user()->rol==='becario')
        {
            $status=Auth::user()->becario->status;
        }
        else{
            $status=Auth::user()->mentor->status;
        }

        if(($status!=='inactivo') &&($request->get('titulo')==='reincorporacion')){
            flash('Error** no puede solicitar reincorporacion ya que Actualmente se encuentra en el programa','danger')->important();
            return redirect()->route('solicitud.showlist');
        }
        $controlQuery = Solicitud::query()->select('titulo')->where('user_id','=',Auth::user()->id)->where('status','=','enviada')
            ->whereIn('titulo',['desincorporacion temporal','desincorporacion definitiva','reincorporacion'])->get();
        $control= $controlQuery->pluck('titulo')->toArray();

        $clave = array_search( $request->get('titulo'),$control); // me devuelve falso si  no encontro elemento

        if(!is_bool($clave))
        {
            flash('Error** Actualmente usted ya hizo una solicitud tipo '.$request->get('titulo').' la cual se encuentra en estado enviada','danger')->important();
            return redirect()->route('solicitud.showlist');
        }

        $solicitud= new Solicitud($request->all());

        if($solicitud->titulo==='desincorporacion definitiva')
          $solicitud->fecha_desincorporacion=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_desincorporacion').' 00:00:00');
        else
            if($solicitud->titulo==='desincorporacion temporal')
                $solicitud->fecha_inactividad=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_inactividad').' 00:00:00');

        $solicitud->user_id=Auth::user()->id;

        if($solicitud->save())
        {
            event(new SolicitudesAlerts($solicitud));
            flash('Su solicitud fue enviada exitosamente','success')->important();
        }
        else{

            flash('Ha ocurrido un error al enviar solicitud','danger')->important();
        }

        return redirect()->route('solicitud.showlist');


    }

    public function solicitudEdit($id)
    {

        $solicitud = Solicitud::find($id);


        if(is_null($solicitud)|| ($solicitud->user_id!=Auth::user()->id))
        {
            flash('El Archivo solicitado no ha sido encontrado','danger')->important();
            return back();
        }

        $alerta= Alerta::query()->select()->where('solicitud','=',$id)->where('status','=','generada')->first();

        if(!is_null($alerta)) {
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
            $solicitud->fecha_desincorporacion=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_desincorporacion').' 00:00:00');
        else
            if($solicitud->titulo==='desincorporacion temporal')
                $solicitud->fecha_inactividad=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_inactividad').' 00:00:00');


        if(($solicitud->user_id==Auth::user()->id) &&($solicitud->status==='enviada') && $solicitud->save())
        {
            Alerta::where('solicitud', $id)->delete();
            event(new SolicitudesAlerts($solicitud));
            flash('Solicitud actualizada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al actualizar su Solicitud.')->error()->important();
        }

        return  redirect()->route('solicitud.showlist');

    }

    public function solicitudDestroy($id)
    {
        $solicitud = Solicitud::find($id);
        if(is_null($solicitud))
        {
            flash('El Archivo solicitado no ha sido encontrado.')->error()->important();
            return back();
        }


        if(($solicitud->user_id==Auth::user()->id) &&($solicitud->status==='enviada') && $solicitud->delete())
        {
            Alerta::where('solicitud', $id)->delete();
            flash('Su Solicitud ha sido eliminada exitosamente.','info')->important();
        }
        else
        {
            flash('Ha Ocurrido un error al eliminar solicitud.')->error()->important();
        }

        return  redirect()->route('solicitud.showlist');
    }
}
