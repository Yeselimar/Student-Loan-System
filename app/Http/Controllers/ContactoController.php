<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Contacto;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactoController extends Controller
{
    public function index()
    {
        $contactos = Contacto::all();
        return view('sisbeca.contactos.index')->with(compact('contactos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|min:2,max:255',
            'correo'          => 'required|email',
            'telefono'        => 'required|min:11,max:15',
            'asunto'          => 'required|min:2,max:255',
            'mensaje'         => 'required|min:2,max:10000',
        ]);

        $contacto = new Contacto;
        $contacto->nombre_completo = $request->nombre_completo;
        $contacto->correo = $request->correo;
        $contacto->telefono = $request->telefono;
        $contacto->asunto = $request->asunto;
        $contacto->mensaje = $request->mensaje;
        $contacto->save();

        $data = array(
            "nombre_completo" => $contacto->nombre_completo,
            "correo" => $contacto->correo,
            "telefono" => $contacto->telefono,
            "asunto" => $contacto->asunto,
            "mensaje" => $contacto->mensaje,
            "fecha_hora" => date("d/m/Y H:i A"),
        );
        //Enviar correo a la persona que escribe por el formulario
        $mail = new PHPMailer(true);
        
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Timeout  = 60;
            $mail->CharSet = "utf-8";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "TLS";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->Username = "delgadorafael2011@gmail.com";
            $mail->Password = "scxxuchujshrgpao";

            $mail->setFrom("no-responder@avaa.org", "Sisbeca");
            $mail->Subject = "Contacto";
            $body = view("emails.contacto.gracias")->with(compact("data"));
            $mail->MsgHTML($body);
            $mail->addAddress($contacto->correo);
            $mail->send();
       
        //Enviar correo al administrador del sistema: Bapssy
        $mail = new PHPMailer(true);
        try
        {
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Timeout  = 60;
            $mail->CharSet = "utf-8";
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = "TLS";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->Username = "delgadorafael2011@gmail.com";
            $mail->Password = "scxxuchujshrgpao";

            $mail->setFrom("no-responder@avaa.org", "Sisbeca");
            $mail->Subject = "Contacto Nuevo";
            $body = view("emails.contacto.info")->with(compact("data"));
            $mail->MsgHTML($body);
            $mail->addAddress("rafael1delgado@hotmail.com");
            $mail->send();
        }
        catch (phpmailerException $e)
        {
        }
        catch (Exception $e)
        {
        }
        return response()->json(['success'=>'¡Gracias por escribirnos, en breve te contactaremos!']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
