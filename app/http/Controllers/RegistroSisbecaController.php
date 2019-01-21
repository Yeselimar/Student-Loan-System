<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use avaa\Documento;
use avaa\Imagen;
use DateTime;
use avaa\User;
use avaa\Becario;
use Timestamp;

class RegistroSisbecaController extends Controller
{
    public function registropostulantementor()
    {
    	return view('auth.registerMentor');
    }

    public function guardarpostulantementor(Request $request)
    {
    	$user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->last_name = $request->last_name;
        $user->fecha_nacimiento = DateTime::createFromFormat('d/m/Y H:i:s', $request->fecha_nacimiento.' 00:00:00');
        $user->password = bcrypt($request->password);
        $user->cedula = $request->cedula;
        $user->sexo = $request->sexo;
        $user->rol= 'pre_postulante_mentor';
        $user->edad = $request->edad;//redundante
        $user->save();

    	/* $file = $request->file('url_pdf');
        $name = 'HojaDeVida_' . time() . '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/documentos/mentores/';
        $file->move($path, $name);
        $documento = new Documento();
        $documento->user_id = $user->id;
        $documento->url = '/documentos/mentores/'.$name;
        $documento->titulo='hoja_vida';
        $documento->save();
 */
        $file = $request->file('image_perfil');

        if(!is_null($file))
        {
            $name = 'img-user_' . $user->cedula . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/images/perfil/';
            $file->move($path, $name);
            $img_perfil = new Imagen();
            $img_perfil->titulo = 'img_perfil';
            $img_perfil->url = '/images/perfil/' . $name;
            $img_perfil->verificado = true;
            $img_perfil->user_id = $user->id;
            $img_perfil->save();
        }
        flash("Gracias registrarse. Ahora puede iniciar sesión para culminar su proceso de postulación.",'success');
        return redirect('/login');

    }

    public function registropostulantebecario()
    {
    	return view('auth.register');
    }

    public function guardarpostulantebecario(Request $request)
    {
    	$user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->last_name = $request->last_name;
        $user->fecha_nacimiento = DateTime::createFromFormat('d/m/Y H:i:s', $request->fecha_nacimiento.' 00:00:00');
        $user->password = bcrypt($request->password);
        $user->cedula = $request->cedula;
        $user->sexo = $request->sexo;
        $user->edad = $request->edad;
        $user->save();

        $becario = new Becario;
        $becario->user_id = $user->id;
        $becario->mentor_id = null;
        $becario->save();

        $file= $request->file('image_perfil');
        if(!is_null($file))
        {
            $name = 'img-user_' . $user->cedula . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/images/perfil/';
            $file->move($path, $name);
            $img_perfil = new Imagen();
            $img_perfil->titulo = 'img_perfil';
            $img_perfil->url = '/images/perfil/' . $name;
            $img_perfil->verificado = true;
            $img_perfil->user_id = $user->id;
            $img_perfil->save();
        }
        flash("Gracias por Registrarse en Pro-excelencia. Ahora puede iniciar sesión para comenzar el proceso de Postulación.",'success');
        return redirect('/login');
    }
}
