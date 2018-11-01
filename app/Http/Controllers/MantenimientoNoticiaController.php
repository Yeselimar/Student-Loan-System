<?php

namespace avaa\Http\Controllers;

use avaa\Noticia;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use Redirect;
use Yajra\Datatables\Datatables;
use Laracasts\Flash\Flash;
use avaa\Http\Requests\NoticiaRequest;
use Validator;
use Illuminate\Validation\Rule;

class MantenimientoNoticiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('editor');
    }

    public function index(Request $request)
    {
        $noticias = Noticia::all();
        return view('sisbeca.noticias.mantenimientoNoticia')->with(compact('noticias'));
    }

    public function create(Request $request)
    {
        return view('sisbeca.noticias.crearNoticia');
    }

    public function store(NoticiaRequest $request)
    {

        $file= $request->file('url_imagen');
        $name = 'noticiasAVAA_' . time() . '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/images/noticias/';
        $file->move($path, $name);
        $noticia = new Noticia($request->all());
        $noticia->slug = Noticia::getSlug($noticia->titulo);
        $noticia->user_id = \Auth::user()->id;
        $noticia->url_imagen = '/images/noticias/'.$name;
        $tipo= ( 'noticia' === $noticia->tipo ) ? 'Noticia' : 'Miembro Institucional';
        if($noticia->save())
        {
            flash('La publicación tipo: '.$tipo.' fue registrada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al registrar el publicación')->error()->important();
        }
        return redirect()->route('noticia.index');
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $noticia = Noticia::find($id);
        if(is_null($noticia))
        {
            flash('El Archivo solicitado no ha sido encontrado')->error()->important();
            return back();
        }
        return view('sisbeca.noticias.editarNoticia')->with('noticia',$noticia);
    }

    public function update(NoticiaRequest $request, $id)
    {
        $noticia = Noticia::find($id);
        $file= $request->file('url_imagen');
        if($request->tipo==='miembroins')
        {
            $errores = Validator::make($request->all(), [
                'url_articulo' => 'required|url',
                'email_contacto' => [
                    Rule::unique('noticias')->ignore($noticia->id),
                ],
                'email_contacto' => 'nullable|email|max:30',

            ])->validate();
        }
        
        $es_archivo=is_file(public_path() .$noticia->url_imagen);
        if($es_archivo)
        {
            unlink(public_path() .$noticia->url_imagen);
        }
        $name = 'noticiasAVAA_' . time() . '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/images/noticias/';
        $file->move($path, $name);

        $noticia->fill($request->all());
        $noticia->slug = Noticia::getSlug($noticia->titulo);
        $noticia->editor_id = \Auth::user()->id;
        $noticia->url_imagen = '/images/noticias/'.$name;
        if($noticia->save())
        {
            flash('La publicación fue actualizada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al actualizar publicación.')->error()->important();
        }
        return  redirect()->route('noticia.index');
    }

    public function destroy($id)
    {
        $noticia= Noticia::find($id);
        if(is_null($noticia))
        {
            flash('El Archivo solicitado no ha sido encontrado.')->error()->important();
            return back();
        }
        if($noticia->delete())
        {
            $es_archivo=file_exists(public_path() .$noticia->url_imagen);
            if($es_archivo)
                     unlink(public_path() .$noticia->url_imagen);
            flash('La publicación ha sido eliminada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha Ocurrido un error al eliminar publicación.')->error()->important();
        }
        return  redirect()->route('noticia.index');
    }
}
