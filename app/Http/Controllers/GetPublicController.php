<?php

namespace avaa\Http\Controllers;

use avaa\Costo;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\Noticia;
use avaa\User;
use avaa\Becario;
use avaa\Actividad;
use avaa\ActividadBecario;
use avaa\Voluntariado;
use avaa\Curso;
use avaa\Materia;
use avaa\Documento;
use avaa\FactLibro;
use avaa\Editor;
use avaa\Periodo;
use avaa\Coordinador;
use avaa\Mentor;
use avaa\Aval;
use Illuminate\Support\Facades\DB;
use Redirect;
use Yajra\Datatables\Datatables;
use Mail; 
use DateTime;

class GetPublicController extends Controller
{

    public function prueba()
    {
        //return date('Y-m-d H:i:s');
        /*$ab = ActividadBecario::find(8);
        $ab->updated_at = date("Y-m-d H:i:s");
        $ab->save();
        return "exito";
        */
        /*$becario = Becario::find(34);
        $becario->hora_entrevista = "3:23 PM";
        $becario->lugar_entrevista = "miami";
        $becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', "14/02/2019" )->format('Y-m-d');
        $becario->save();
        return "exito";*/
        $hora = DateTime::createFromFormat('H:i a', "03:22 AM" )->format('H:i:s');
        //$hora = date("h:i A", strtotime("3:22 PM"));
        //$fecha = "14/02/1993".' '.date("h:i a", strtotime("3:22 PM"));
        //$fechan = DateTime::createFromFormat('d/m/Y h:i A', $fecha )->format('Y-m-d H:i:s');
        return response()->json( date("h:i a", strtotime($hora)) ); 
        /*$entrevistadores = User::entrevistadores()->get();
        return $entrevistadores;
        */
        //prueba para enviar email
        /*$request= "";
        Mail::send('emails.base',  
            array(
                'name'          => 'Rafael Delgado',
                'addressee'     => 'delgadorafael2011@gmail.com',
                'message'       => 'prueba',
                'location'      => 'delgadorafael2011@gmail.com'
            ), function($message) use ($request)
        {
            $message->from('no-reply@bdc.com.co');
            $message->to('delgadorafael2011@gmail.com', 'delgadorafael2011@gmail.com')->subject('Avvaa.');   
        });/*

        //otra forma
        /*Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
        {
            $message->subject('stmp and Laravel are awesome!');
            $message->from('soporte@genesyzgroup.com', 'Website Name');
            $message->to('delgadorafael2011@gmail.com');
        });
        return "exito";

        */


        /*
        $mail = new PHPMailer(true);
                try
                {
                    $mail->isSMTP();  
                    $mail->CharSet = "utf-8";
                    $mail->SMTPAuth = true; 
                    $mail->SMTPSecure = "SSL";
                    $mail->Host = "mail.hotelcoralsuites.com";
                    $mail->Port = 25;
                    $mail->Username = "webmaster@hotelcoralsuites.com";
                    $mail->Password = "Mars$2905";
                    $mail->setFrom("info@hotelcoralsuites.com", "Hotel Coral Suites");
                    $mail->Subject = "Contacto";
                    $mail->MsgHTML($body);
                    foreach($correos as $correo)
                    {
                        $mail->addAddress($correo, " ");
                    }
                    $mail->send();
                }
                catch (phpmailerException $e)
                {
                    $enviado = false;
                    $error = "01";
                }
                catch (Exception $e)
                {
                    $enviado = false;
                    $error = "02";
                }
        return "enviado";
        //relación de becarios a actividades
        /*
        $becario = Becario::find(5);
        return  $becario->actividades;
        */
        
        //relacion actividad_becario a aval
        /*
        $actividad_becario = ActividadBecario::where('becario_id','=','5')->where('actividad_id','=','1')->first();
        return $actividad_becario->aval;
        */

        //relación de actividades a becarios
        /*
        $actividad = Actividad::find(2);
        return $actividad->becarios->count();
        foreach($actividad->becarios as $becario) 
        {
            return  $becario->user;
        }
        */

        //relación de becarios a cursos
        /*
        $becario = Becario::find(5);
        return $becario->cursos->first()->tipocurso->nombre;
        return $becario->cursos->first()->aval;
        */

        //relación de cursos a becarios
        /*
        $curso = Curso::find(1);
        return $curso->becario->user;
        */

        //relación becario a voluntariados
        /*
        $becario = Becario::find(5);
        return $becario->voluntariados;
        */

        //relación voluntariado a becario
        /*
        $voluntariado = Voluntariado::find(1);
        return $voluntariado->aval;
        return $voluntariado->becario->user;
        */

        //relación becario a periodos
        /*
        $becario = Becario::find(5);
        return $becario->periodos;
        */

        //relación a periodo a materias
        /*
        $periodo = Periodo::find(1);
        return $periodo->materias;
        return $periodo->aval->url;
        */

        //relacion materias a periodo
        /*
        $materia = Materia::find(1);
        return $materia->periodo;
        */

        //relación actividades a facilitadores
        /*
        $actividad = Actividad::find(1);
        //return response()->json($actividad->facilitadores[1]->becario_id==null);// cuando no es becario
        return $actividad->facilitadores->first()->becario;
        */

        //relación becarios a actividadesfacilitadas (becario como facilitador de una actividad)
        /*
        $becario = Becario::find(5);
        return $becario->actividadesfacilitadas;
        */

        //relacion de becario a entrevistador
        
        /*$becario = Becario::find(4);
        return $becario->entrevistadores;
        
        //relacion de entrevistador a becario
        
        $entrevistador = User::find(47)->;
        return $entrevistador->entrevistados;
        */


        //probar desasignar mentor
        /*
        $becario = Becario::find(4);//en este punto becario no tiene mentor asignado
        $becario->mentor_id = 14;//asigno el mentor, obviamente ya existe ese mentor
        $becario->save();//guardo. esto es importante
        return $becario->mentor;//aqui puedo observar de que la relacion sirve y la asignacion  fue exitosa

        $becario->mentor_id = null;//quito la relacion becario mentor
        $becario->save();// guardo
        return $becario;// compruebo de que fue exitosa

        $mentores = Mentor::all();//listo mis mentores
        return $mentores;
        */
    }  

    public function getNoticias($tip=1)
    {
        $noticias=null;
        if($tip==0)
        {
            $noticias = Noticia::query()->select(['id', 'titulo', 'contenido', 'tipo'])->orderBy('updated_at','desc');
            $objeto= Datatables::of($noticias)->addColumn('fechaActualizacion', function ($noticias) {
                $noti=Noticia::find($noticias->id); //llamo al regististro actual
                //$noti->editor; //aqui lo que hago es llamar a la relaciones para cada uno de las noticias
                $fecha_actual=date("d/m/Y h:i:m A", strtotime($noti->updated_at));
                return $fecha_actual; // Retorna al Fecha Actualizacion

            })->addColumn('content', function ($noticias) {
                $content= $noticias->contenido;
                $content=substr(strip_tags($content), 0, 20).'...';// Esto elimina las etiquetas html
                return  $content;

            })->addColumn('tipoA', function ($noticias) {
                $tipoA= ( 'noticia' === $noticias->tipo ) ? 'Noticia' : 'Miembro Institucional';
                return  $tipoA;

            })->addColumn('title', function ($noticias)
            {
                $title= $noticias->titulo;
                $title=substr(strip_tags($title), 0, 30).'...';
                return  $title;

            })->make(true);
        }
        else
        {
            $noticias = Noticia::select(['id', 'titulo', 'contenido', 'tipo'])->where('tipo','=','noticia')->orderBy('updated_at','desc');
            $objeto= Datatables::of($noticias)->make(true);
        }
        return $objeto;
    }

    public function generarBD()
    {
        $admin = User::find(1);
        $admin->rol = 'admin';
        $admin->email='admin@avaa.com';
        $admin->save();

        $directivo = User::find(2);
        $directivo->rol = 'directivo';
        $directivo->email='directivo@avaa.com';
        $directivo->save();

        $editor = User::find(3);
        $editor->rol = 'editor';
        $editor->email='editor@avaa.com';
        $editor->save();

        $editor = User::find(4);
        $editor->rol = 'coordinador';
        $editor->email='coordinador@avaa.com';
        $editor->save();

        $editor = User::find(5);
        $editor->rol = 'entrevistador';
        $editor->email='entrevistador@avaa.com';
        $editor->save();
        //$editor->editor()->save(new Editor());


        /*

        $editor = new Editor;
        $editor->user_id = 2;
        $editor->save();

        $coordinador = new Coordinador;
        $coordinador->user_id = 3;
        $coordinador->save();

        $mentor = new Mentor;
        $mentor->user_id = 4;
        $mentor->save();
        */
/*
        for($i=5,$j=1;$i<8;$i++,$j++) {
            $coordinador = User::find($i);
            $coordinador->rol = 'coordinador';
            $coordinador->email= 'coord'.$j.'@avaa.com';
            $coordinador->save();

            $coordinador = new Coordinador;
            $coordinador->user_id = $i;
            $coordinador->save();
        }
*/

        $usuarios = User::where('rol','=','becario')->get();

        foreach($usuarios as $usuario)
        {
            $becario = new Becario();
            $becario->user_id = $usuario->id;
            $becario->mentor_id = null;
            $becario->acepto_terminos = true;
            $becario->status='activo';
            $becario->cuenta_bancaria= $this->getRandomCode();
            $becario->save();
            
           /* $documento = new Documento();
            $titulo = str_random(10);
            $documento->titulo = $titulo;
            $documento->url = '/'.$titulo.'.pdf';
            $documento->user_id = $usuario->id;
            $documento->verificado = 0;
            $documento->save();*/

          /*  $factlibro = new FactLibro();
            $name = str_random(10);
            $factlibro->name = $name;
            $factlibro->curso =  str_random(10);
            $factlibro->url = '/'.$name.'.pdf';
            $factlibro->status = 'cargada';
            $factlibro->costo = rand(1000, 2000) / 10;
            $factlibro->becario_id  = $usuario->id;
            $factlibro->save();*/

            //return $factlibro;

        }
        
        for($i=10;$i<=30;$i++)
        {
            $usuarios->get($i)->rol= 'postulante_becario';
            $usuarios->get($i)->save();

            $usuarios->get($i)->becario->status='postulante';
             $usuarios->get($i)->becario->save();
        }

        $costo= new Costo();
        $costo->sueldo_becario =1000000;
        $costo->fecha_valido=date('Y-m-d');
        $costo->save();


        return 'Listo';

    }

    public function getRandomCode(){
        $an = "0123456789";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1).
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1).
            substr($an, rand(0, $su), 1).
            substr($an, rand(0, $su), 1);
    }


}
