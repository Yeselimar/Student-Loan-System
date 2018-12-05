<?php

namespace avaa\Http\Controllers;

use avaa\Alerta;
use avaa\Costo;
use avaa\Events\SolicitudesAlerts;
use avaa\Solicitud;
use avaa\User;
use Illuminate\Http\Request;
use Auth;
use DateTime;
use Timestamp;
use avaa\Mentor;
use avaa\Becario;
use avaa\Imagen;
use avaa\Documento;

class SisbecaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $usuario =  Auth::user();
        $becario = Becario::where('user_id','=',$usuario->id)->first();
        //return $usuario;
        return view('sisbeca.index')->with('usuario',$usuario)->with('becario',$becario);
    }



    public function allNotificaciones()
    {

        if(Auth::user()->rol==='coordinador' or Auth::user()->rol==='directivo')
        {
            $becariosAsignados= Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactivo'])->get();
            $listaBecariosA=$becariosAsignados->pluck('user_id')->toArray();

            $collection = collect();
            foreach ($becariosAsignados as $beca)
            {

                $collection->push($beca->mentor);
            }
            $listMentoresA=$collection->pluck('user_id')->toArray();

            $mentoresAsignados= Mentor::query()->whereIn('user_id',$listMentoresA)->get();

            $listaMentoresA= $mentoresAsignados->pluck('user_id')->toArray();


            $alertas = Alerta::query()->where('status','=','enviada')->whereIn('user_id',[$listaBecariosA,$listaMentoresA])->get();
            Alerta::where('status','=','enviada')->whereIn('user_id',[$listaBecariosA,$listaMentoresA])->update(array('leido' => true));

        }
        else
        {
            $alertas = Alerta::query()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'generada')->get();
                Alerta::where('status', '=', 'generada')->where('user_id', '=', Auth::user()->id)->update(array('leido' => true));
        }
        return  view('sisbeca.notificaciones.listarNotificaciones')->with('notificaciones',$alertas);
    }

    public function statusPostulanteMentor()
    {
        return view('sisbeca.postulaciones.statusMentoria');
    }

    public function statusPostulanteBecario()
    {
        $postulante = Becario::find(Auth::User()->id);
        $entrevistadores = User::entrevistadores()->get();
        return view('sisbeca.postulaciones.statusPostulanteBecario')->with('postulante',$postulante)->with('entrevistadores',$entrevistadores);
    }

    public function perfil($id)
    {
        if((Auth::user()->rol!=='postulante_becario') && (Auth::user()->rol!=='becario') && (Auth::user()->rol!=='mentor') && (Auth::user()->rol!=='directivo') && (Auth::user()->rol!=='coordinador'))
        {
            flash('Disculpe, el archivo solicitado no fue encontrado.','danger')->important();
            return back();
        }
        $user= User::find($id);
        if($user->rol!=='becario' && $user->rol!=='postulante_becario')
        {
            flash('Disculpe, el archivo solicitado no fue encontrado.','danger')->important();
            return back();
        }
        $becario = Becario::find($id);
        $usuario = Auth::user();
        $img_perfil = Imagen::where('user_id','=',$id)->where('titulo','=','img_perfil')->first();
        $fotografia = Imagen::where('user_id','=',$id)->where('titulo','=','fotografia')->first();
        $cedula = Imagen::where('user_id','=',$id)->where('titulo','=','cedula')->first();
        $constancia_cnu = Documento::where('user_id','=',$id)->where('titulo','=','constancia_cnu')->first();
        $calificaciones_bachillerato = Documento::where('user_id','=',$id)->where('titulo','=','calificaciones_bachillerato')->first();
        $constancia_aceptacion = Documento::where('user_id','=',$id)->where('titulo','=','constancia_aceptacion')->first();
        $constancia_estudios = Documento::where('user_id','=',$id)->where('titulo','=','constancia_estudios')->first();
        $calificaciones_universidad = Documento::where('user_id','=',$id)->where('titulo','=','calificaciones_universidad')->first();
        $constancia_trabajo = Documento::where('user_id','=',$id)->where('titulo','=','constancia_trabajo')->first();
        $declaracion_impuestos = Documento::where('user_id','=',$id)->where('titulo','=','declaracion_impuestos')->first();
        $recibo_pago = Documento::where('user_id','=',$id)->where('titulo','=','recibo_pago')->first();
        $referencia_profesor1 = Documento::where('user_id','=',$id)->where('titulo','=','referencia_profesor1')->first();
        $referencia_profesor2 = Documento::where('user_id','=',$id)->where('titulo','=','referencia_profesor2')->first();
        $ensayo = Documento::where('user_id','=',$id)->where('titulo','=','ensayo')->first();
        return view('sisbeca.becarios.perfil')->with('becario',$becario)->with('usuario',$usuario)->with('fotografia',$fotografia)->with('cedula',$cedula)->with('constancia_cnu',$constancia_cnu)->with('calificaciones_bachillerato',$calificaciones_bachillerato)->with('constancia_aceptacion',$constancia_aceptacion)->with('constancia_estudios',$constancia_estudios)->with('calificaciones_universidad',$calificaciones_universidad)->with('constancia_trabajo',$constancia_trabajo)->with('declaracion_impuestos',$declaracion_impuestos)->with('recibo_pago',$recibo_pago)->with('referencia_profesor1',$referencia_profesor1)->with('referencia_profesor2',$referencia_profesor2)->with('ensayo',$ensayo)->with('img_perfil',$img_perfil);
    }

    public function verMiPerfilMentor()
    {
        $postulante= User::find(Auth::user()->id);
        $img_perfil_postulante=Imagen::query()->where('user_id','=',$postulante->id)->where('titulo','=','img_perfil')->get();
        $documento = Documento::query()->where('user_id', '=', $postulante->id)->where('titulo', '=', 'hoja_vida')->first();
        return view('sisbeca.postulaciones.perfilPostulanteMentor')->with('postulanteMentor',$postulante)->with('documento', $documento)
            ->with('img_perfil_postulante',$img_perfil_postulante);
    }

}
