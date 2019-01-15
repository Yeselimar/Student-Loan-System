<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Aval;
use avaa\ActividadBecario;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AvalController extends Controller
{
	//este método es usado por varias vistas
   	public function getEstatus()
	{
		$estatus = (object)["0"=>"pendiente", "1"=>"aceptada", "2"=>"negada","3"=>"devuelto"];
		return response()->json(['estatus'=>$estatus]);
	}

	//este método es usado por varias vistas no cambiar el nombre del success
 	public function actualizarestatus(Request $request, $id)
	{
		$aval = Aval::find($id);
		$aval->estatus = $request->estatus;
		$aval->save();
		return response()->json(['success'=>'El estatus fue actualizado exitosamente.']);
	}

	public function aceptar($id)
	{
		$aval = Aval::find($id);
		$aval->estatus = "aceptada";
		$aval->save();

		$ab = ActividadBecario::paraAval($id)->first();
		$ab->estatus = "asistio";
		$ab->save();
		
		$actividad = $ab->actividad;
		$becario = $aval->becario;

		$data = array(
            "becario" => $becario->user->nombreyapellido(),
            "fecha_hora" =>  date("d/m/Y h:i A"),
            "actividad_tipo" => $actividad->getTipo(),
            "actividad_nombre" => $actividad->nombre,
            "estatus_justificativo" => "ACEPTADA",
            "estatus_actividad" => "ASISTIÓ",
        );
       	//Enviar correo al becario notificandole
        $mail = new PHPMailer(true);
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
        $mail->Subject = "Notificación";
        $body = view("emails.actividades.notificacion-justificativo-aceptada")->with(compact("data"));
        $mail->MsgHTML($body);
        $mail->addAddress($becario->user->email);
        $mail->send();

		return response()->json(['success'=>'La justificación fue aceptada exitosamente.']);
	}

	public function devolver($id)
	{
		//generar un alerta para que el becario se entere de que su justificativo fue devuelto
		$aval = Aval::find($id);
		$aval->estatus = "devuelto";
		$aval->save();

		$ab = ActividadBecario::paraAval($id)->first();
		$ab->estatus = "justificacion cargada";
		$ab->save();

		$actividad = $ab->actividad;
		$becario = $aval->becario;

		$data = array(
            "becario" => $becario->user->nombreyapellido(),
            "actividad_tipo" => $actividad->getTipo(),
            "actividad_nombre" => $actividad->nombre,
            "estatus_justificativo" => "DEVUELTO",
        );
       	//Enviar correo al becario notificandole
        $mail = new PHPMailer(true);
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
        $mail->Subject = "Notificación";
        $body = view("emails.actividades.notificacion-justificativo-devuelto")->with(compact("data"));
        $mail->MsgHTML($body);
        $mail->addAddress($becario->user->email);
        $mail->send();
		
		return response()->json(['success'=>'La justificación fue devuelta exitosamente.']);
	}

	public function negar($id)
	{
		$aval = Aval::find($id);
		$aval->estatus = "negada";
		$aval->save();

		$ab = ActividadBecario::paraAval($id)->first();
		$ab->estatus = "no asistio";
		$ab->save();
		
		$actividad = $ab->actividad;
		$becario = $aval->becario;

		$data = array(
            "becario" => $becario->user->nombreyapellido(),
            "fecha_hora" =>  date("d/m/Y h:i A"),
            "actividad_tipo" => $actividad->getTipo(),
            "actividad_nombre" => $actividad->nombre,
            "estatus_justificativo" => "NEGADA",
            "estatus_actividad" => "NO ASISTIÓ",
        );
       	//Enviar correo al becario notificandole
        $mail = new PHPMailer(true);
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
        $mail->Subject = "Notificación";
        $body = view("emails.actividades.notificacion-justificativo-negada")->with(compact("data"));
        $mail->MsgHTML($body);
        $mail->addAddress($becario->user->email);
        $mail->send();

		return response()->json(['success'=>'La justificación fue negada exitosamente.']);
	}
}
