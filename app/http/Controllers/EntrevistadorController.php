<?php

namespace avaa\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DateTime;
use Validator;
use avaa\Http\Requests\EntrevistadorRequest;
use File;
use avaa\Becario;
use avaa\BecarioEntrevistador;
use avaa\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EntrevistadorController extends Controller
{
	public function misentrevistados()
	{
		return view('sisbeca.entrevistador.misentrevistados');
	}

	public function listarpostulantesaentrevistar(Request $request)
	{
		$becarios = BecarioEntrevistador::where('entrevistador_id','=',Auth::user()->id)->with("user")->with("becario")->get();
		return response()->json(['becarios'=>$becarios]);
	}

	public function cargardocumento($id)
	{
		$becario =  Becario::find($id);
		$model = "crear";
		return view('sisbeca.entrevistador.cargardocumento')->with(compact('becario','model'));
	}

	public function guardardocumento(Request $request,$id)
	{
        $becario = Becario::find($id);
        $be = BecarioEntrevistador::where('entrevistador_id','=',Auth::user()->id)->where('becario_id','=',$becario->user_id)->first();
        $validation = Validator::make($request->all(), EntrevistadorRequest::cargarDocumento());
        if ( $validation->fails() )
        {
            flash("Por favor, verifique el formulario.",'danger');
            return back()->withErrors($validation)->withInput();
        }

        $archivo= $request->file('documento');
        $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
        $ruta = public_path().'/'.BecarioEntrevistador::carpetaDocumento();
        $archivo->move($ruta, $nombre);

        $be->documento = BecarioEntrevistador::carpetaDocumento().$nombre;
        $be->save();

        flash("El documento al becario ".$becario->user->nombreyapellido()." fue cargado exitosamente.",'success');
        return redirect()->route('entrevistador.misentrevistados');
	}

	public function editardocumento($id)
	{
		$becario =  Becario::find($id);
		$be = BecarioEntrevistador::where('entrevistador_id','=',Auth::user()->id)->where('becario_id','=',$becario->user_id)->first();
		$model = "editar";
		return view('sisbeca.entrevistador.cargardocumento')->with(compact('becario','be','model'));
	}

	public function actualizardocumento(Request $request,$id)
	{
		$becario = Becario::find($id);
        $be = BecarioEntrevistador::where('entrevistador_id','=',Auth::user()->id)->where('becario_id','=',$becario->user_id)->first();
        $validation = Validator::make($request->all(), EntrevistadorRequest::actualizarDocumento());
        if ( $validation->fails() )
        {
            flash("Por favor, verifique el formulario.",'danger');
            return back()->withErrors($validation)->withInput();
        }

		if($request->file('documento'))
        {
            File::delete($be->documento);

            $archivo= $request->file('documento');
	        $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
	        $ruta = public_path().'/'.BecarioEntrevistador::carpetaDocumento();
	        $archivo->move($ruta, $nombre);

	        $be->documento = BecarioEntrevistador::carpetaDocumento().$nombre;
	        $be->save();
        }

        flash("El documento al becario ".$becario->user->nombreyapellido()." fue actualizado exitosamente.",'success');
        return redirect()->route('entrevistador.misentrevistados');
	}

	public function documentoconjunto($id)
	{
		$becario =  Becario::find($id);
		$model = "crear";
		return view('sisbeca.entrevistador.modeldocumentoconjunto')->with(compact('becario','model'));
	}

	public function guardardocumentoconjunto(Request $request, $id)
	{
		$becario = Becario::find($id);
        $validation = Validator::make($request->all(), EntrevistadorRequest::cargarDocumentoConjunto());
        if ( $validation->fails() )
        {
            flash("Por favor, verifique el formulario.",'danger');
            return back()->withErrors($validation)->withInput();
        }

        $archivo= $request->file('documento');
        $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
        $ruta = public_path().'/'.BecarioEntrevistador::carpetaDocumentoConjunto();
        $archivo->move($ruta, $nombre);

        $becario->documento_final_entrevista = BecarioEntrevistador::carpetaDocumentoConjunto().$nombre;
        $becario->save();

        flash("El documento conjunto del becario ".$becario->user->nombreyapellido()." fue cargado exitosamente.",'success');
        return redirect()->route('entrevistador.asignar');
	}

	public function editardocumentoconjunto($id)
	{
		$becario =  Becario::find($id);
		$model = "editar";
		return view('sisbeca.entrevistador.modeldocumentoconjunto')->with(compact('becario','model'));
	}

	public function actualizardocumentoconjunto(Request $request, $id)
	{
		$becario = Becario::find($id);
        $validation = Validator::make($request->all(), EntrevistadorRequest::actualizarDocumentoConjunto());
        if ( $validation->fails() )
        {
            flash("Por favor, verifique el formulario.",'danger');
            return back()->withErrors($validation)->withInput();
        }
        if($request->file('documento'))
        {
            File::delete($becario->documento_final_entrevista);

	        $archivo= $request->file('documento');
	        $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
	        $ruta = public_path().'/'.BecarioEntrevistador::carpetaDocumentoConjunto();
	        $archivo->move($ruta, $nombre);

	        $becario->documento_final_entrevista = BecarioEntrevistador::carpetaDocumentoConjunto().$nombre;
	        $becario->save();
	    }
        flash("El documento conjunto del becario ".$becario->user->nombreyapellido()." fue actualizado exitosamente.",'success');
        return redirect()->route('entrevistador.asignar');
	}

	public function asignarentrevistadores()
	{
		return view('sisbeca.entrevistador.asignar')->with(compact('becarios'));
	}

	public function obtenerpostulantes()
	{
		$becarios = Becario::where('status','=','entrevista')->orwhere('status','=','entrevistado')->with("user")->with('entrevistadores')->get();
		return response()->json(['becarios'=>$becarios]);
	}

	public function obtenerentrevistadores()
	{
		$entrevistadores = User::entrevistadores()->get();
		return response()->json(['entrevistadores'=>$entrevistadores]);
	}

	public function guardarasignarentrevistadores(Request $request,$id)
	{
		//validar hora y fecha
		$becario = Becario::find($id);
		$becario->lugar_entrevista = $request->lugar;
		$becario->hora_entrevista = DateTime::createFromFormat('H:i a', $request->hora )->format('H:i:s');
		$becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', $request->fecha )->format('Y-m-d');
		$becario->save();

		foreach ($becario->entrevistadores as $entrevistador)
		{
			$entrevistador_becario = BecarioEntrevistador::where('becario_id','=',$id)->where('entrevistador_id','=',$entrevistador->id)->delete();
		}

		if($request->has('seleccionados') and $request->get('seleccionados')!=null)
		{
			$tmp = explode(',', $request->get('seleccionados'));
			foreach ($tmp as $index=>$seleccion)
			{
				$nuevo = new BecarioEntrevistador;
				$nuevo->becario_id = $id;
				$nuevo->entrevistador_id = $seleccion;
				$nuevo->save();
			}
		}

		$becario = Becario::find($id);
		
		//Enviar correo a la persona notificando
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "TLS";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->Username = "delgadorafael2011@gmail.com";
        $mail->Password = "scxxuchujshrgpao";
        $mail->setFrom("no-responder@avaa.org", "Sisbeca");
        $mail->Subject = "IMPORTANTE";
        $body = view("emails.becarios.notificacion-entrevista")->with(compact("becario"));
        $mail->MsgHTML($body);
        $mail->addAddress($becario->user->email);
        $mail->send();

		return response()->json(['success'=>'Los datos de la entrevista fueron actualizados']);
	}

	public function obtenerbecario($id)
	{
		$becario = Becario::find($id);
		return response()->json(['becario'=>$becario]);
	}

	public function documentoindividual()
	{

	}

}
