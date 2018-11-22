<?php

/*
|--------------------------------------------------------------------------
| 2018
*/

//Web Site
Route::get('cache', function(){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return '<h1> Las Caches fueron Limpiadas con exito </h1>';
    });

Route::get('/prueba','GetPublicController@prueba')->name('prueba');


Route::get('/generarBD','GetPublicController@generarBD')->name('generarBD');


Route::get('/','SitioWebController@index')->name('home');

Route::get('/nosotros', function(){
    return view('web_site.nosotros')->with('route','nosotros');

})->name('nosotros');

Route::get('/programas', 'SitioWebController@programas')->name('programas');

Route::get('/membresias','SitioWebController@membresias')->name('membresias');

Route::get('/contactenos', function(){
    return view('web_site.contactenos')->with('route','contactenos');

})->name('contactenos');

Route::post('/contactenos','ContactoController@store')->name('contacto.store');


Route::get('/noticias','SitioWebController@noticias')->name('noticias');

Route::get('noticia/{slug}/','SitioWebController@showNoticia')->name('showNoticia');

Route::get('/periodo/{id}/obtener-materias', 'PeriodosController@obtenermaterias')->name('materias.obtener');//borrar

Route::post('/periodo/{id}/anadir-materia', 'MateriasController@anadirmateria')->name('materias.anadir');//borrar
Route::post('/periodo/prueba', 'MateriasController@pruebaapi')->name('pruebaapi');//borrar
Route::get('/foo', function ()
{
    $exitCode = Artisan::call('cache:clear');
});



// Get Noticia para obtener todas las noticias en el datatable
Route::get('datatable/getNoticia/{tip?}', 'GetPublicController@getNoticias')->name('datatable/getNoticia');

//Rutas del Sistema de Administracion
Route::group(["prefix"=>"sisbeca",'middleware'=>'auth'],function ()
{
    Route::get('/',['uses'=> 'SisbecaController@index','as' =>'sisbeca']);
     
    //Estas Rutas solo seran accedidas por el Administrador (admin es un middleware
    // creado recordar registrar el middleware creado por el programador en la carpeta Kernel

    Route::group(['middleware'=>['admin_becario']],function ()
    {
        //talleres y chat clubs
        Route::get('/actividades', 'ActividadController@listar')->name('actividad.listar');
        Route::get('/actividades/{id}/detalles', 'ActividadController@detalles')->name('actividad.detalles');

        //talleres y chat club: servicios
        Route::get('/actividades/becarios-facilitador', 'ActividadController@obtenerbecarios')->name('actividad.obtenerbecarios');
        Route::get('/actividades/{id}/detalles/servicio', 'ActividadController@detallesservicio')->name('actividad.detalles.servicio');

        Route::get('/actividad/{actividad_id}/becario/{becario_id}/describir', 'ActividadController@desinscribir')->name('actividad.desinscribir');

        Route::get('/actividad/{actividad_id}/becario/{becario_id}/subir-justificacion', 'ActividadController@subirjustificacion')->name('actividad.subirjustificacion');

        Route::post('/actividad/{actividad_id}/becario/{becario_id}/guardar-justificacion', 'ActividadController@guardarjustificacion')->name('actividad.guardarjustificacion');

         Route::get('/actividad/{actividad_id}/becario/{becario_id}/editar-justificacion', 'ActividadController@editarjustificacion')->name('actividad.editarjustificacion');

        Route::post('/actividad/{actividad_id}/becario/{becario_id}/actualizar-justificacion', 'ActividadController@actualizarjustificacion')->name('actividad.actualizarjustificacion');

        Route::post('/actividad/{actividad_id}/becario/{becario_id}/actualizar-estatus', 'ActividadController@actulizarestatus')->name('actividad.actulizarestatus');
        
    });

    Route::group(['middleware'=>['admin']],function ()
    {
        //actividades
        Route::get('/actividades/crear', 'ActividadController@crear')->name('actividad.crear');
        Route::post('/actividades/guardar', 'ActividadController@guardar')->name('actividad.guardar');
        Route::get('/actividades/{id}/editar', 'ActividadController@editar')->name('actividad.editar');
        Route::post('/actividades/{id}/actualizar', 'ActividadController@actualizar')->name('actividad.actualizar');

        Route::get('/actividad/{id}/inscribir-becario', 'ActividadController@inscribirbecario')->name('actividad.inscribir.becario');
        Route::post('/actividad/{id}/inscribir-becario-guardar', 'ActividadController@inscribirbecarioguardar')->name('actividad.inscribir.guardar');

        Route::get('/actividad/justificativos/', 'ActividadController@listarjustificativos')->name('actividad.listarjustificativos');
        Route::get('/justificativos-todos/servicio', 'ActividadController@obtenerjustificativos')->name('actividad.obtenerjustificativos');

        Route::get('/actividad/{id}/justificativos/todos', 'ActividadController@listarjustificativosactividad')->name('actividad.justificativos.todos');
        Route::get('/actividad/{id}/justificativos/servicio', 'ActividadController@justificativosactividad')->name('actividad.justificativos.servicio');

        //periodos
        Route::get('/periodos/todos', 'PeriodosController@todosperiodos')->name('periodos.todos');
        Route::get('/periodos/obtener-todos', 'PeriodosController@obtenertodos')->name('periodos.obtenertodos');

        //cursos ó cva
        Route::get('/cursos/todos', 'CursoController@todoscursos')->name('cursos.todos');
        Route::get('/cursos/obtener-todos', 'CursoController@obtenertodos')->name('cursos.obtenertodos');

        //aval
        Route::get('/aval/estatus/todos', 'AvalController@getEstatus')->name('aval.getEstatus');
        Route::post('/aval/{id}/actualizar-estatus', 'AvalController@actualizarestatus')->name('aval.actualizarestatus');

        //voluntariado
        Route::Resource('mantenimientoUser', 'MantenimientoUserController');
        Route::get('mantenimientoUser/{id}/destroy', [
            'uses' => 'MantenimientoUserController@destroy',
            'as' => 'mantenimientoUser.destroy'
        ]);


        // Get Data
        Route::get('datatable/getdata', 'MantenimientoUserController@getUsers')->name('datatable/getdata');

    });

    //Estas Rutas solo seran accedidas por el Editor (editor es un middleware
    // creado recordar registrar el middleware creado por el programador en la carpeta Kernel
    Route::group(['middleware'=>'editor'],function ()
    {
        Route::Resource('noticia', 'MantenimientoNoticiaController');
        Route::get('noticia/{id}/eliminar', [
            'uses' => 'MantenimientoNoticiaController@destroy',
            'as' => 'noticia.destroy'
        ]);

        //costos
        Route::get('costos', [
            'uses' => 'MantenimientoEditorController@index',
            'as' => 'costos.index'
        ]);

        Route::get('costos/{id}/editar', [
            'uses' => 'MantenimientoEditorController@edit',
            'as' => 'costos.edit'
        ]);

        Route::post('costos/{id}/actualizar', [
            'uses' => 'MantenimientoEditorController@update',
            'as' => 'costos.update'
        ]);

        Route::Resource('mantenimientoConcurso', 'MantenimientoConcursoController');

        Route::get('mantenimientoConcurso/{id}/destroy', [
            'uses' => 'MantenimientoConcursoController@destroy',
            'as' => 'mantenimientoConcurso.destroy'
        ]);

        //charlas
        Route::get('/charlas', 'CharlaController@index')->name('charla.index');
        Route::get('/charla/crear', 'CharlaController@create')->name('charla.create');
        Route::post('/charla/guardar', 'CharlaController@store')->name('charla.store');
        Route::get('/charla/{id}/editar', 'CharlaController@edit')->name('charla.edit');
        Route::post('/charla/{id}/actualizar', 'CharlaController@update')->name('charla.update');
        Route::get('/charla/{id}/eliminar', 'CharlaController@destroy')->name('charla.destroy');
        //banner
        Route::get('/banners', 'BannerController@index')->name('banner.index');
        Route::get('/banner/crear', 'BannerController@create')->name('banner.create');
        Route::post('/banner/guardar', 'BannerController@store')->name('banner.store');
        Route::get('/banner/{id}/editar', 'BannerController@edit')->name('banner.edit');
        Route::post('/banner/{id}/actualizar', 'BannerController@update')->name('banner.update');
        Route::get('/banner/{id}/eliminar', 'BannerController@destroy')->name('banner.destroy');
        //contacto
        Route::get('/contactos','ContactoController@index')->name('contacto.index');
    });

    //le agregue admin,
    Route::group(['middleware'=>'becario'],function ()
    {
        Route::get('carta/bancaria', [
            'uses' => 'BecarioController@bancariapdf',
            'as' => 'carta.bancaria'
        ]);
        Route::get('inicio/aceptoTerminosCondiciones', [
            'uses' => 'BecarioController@aceptoTerminosCondiciones',
            'as' => 'inicio.aceptoTerminosCondiciones'
        ]);

        Route::post('terminosCondicionesAprobar', [
            'uses' => 'BecarioController@terminosCondicionesAprobar',
            'as' => 'terminosCondiciones.aprobar'
        ]);

        Route::get('verCuentaBancaria', [
            'uses' => 'BecarioController@verCuentaBancaria',
            'as' => 'verCuentaBancaria'
        ]);

        Route::put('cuentaBancaria/updated/{id}', [
            'uses' => 'BecarioController@cuentaBancariaUpdated',
            'as' => 'cuentaBancaria.update'
        ]);

        Route::get('libros/listar-facturas', [
            'uses' => 'FactLibrosController@listar',
            'as' => 'facturas.listar'
        ]);

        Route::get('libros/crear-factura', [
            'uses' => 'FactLibrosController@crear',
            'as' => 'facturas.crear'
        ]);

        Route::post('libros/guardar-factura', [
            'uses' => 'FactLibrosController@guardar',
            'as' => 'facturas.guardar'
        ]);


        Route::get('ver/mentorAsignado', [
            'uses' => 'BecarioController@verMentorAsignado',
            'as' => 'ver.mentorAsignado'
        ]);

        //talleres y chat club
        Route::get('/actividades/{actividad_id}/becario/{becario_id}/inscribirme', 'ActividadController@actividadinscribirme')->name('actividad.inscribirme');
       
        //link para inscribirme y salirme.  justificar


        //periodos
        Route::get('/periodos', 'PeriodosController@index')->name('periodos.index');
        Route::get('/periodo/{id}/ver-constancia', 'PeriodosController@verconstancia')->name('periodos.constancia');
        Route::get('/becario/{id}/crear-periodo/', 'PeriodosController@crear')->name('periodos.crear');
        Route::post('/becario/{id}/;-periodo/', 'PeriodosController@guardar')->name('periodos.guardar');
        Route::get('/becario/{id}/editar-periodo/', 'PeriodosController@editar')->name('periodos.editar');
        Route::post('/becario/{id}/actualizar-periodo/', 'PeriodosController@actualizar')->name('periodos.actualizar');
        Route::get('/periodo/{id}/mostrar-materias/', 'PeriodosController@mostrarmaterias')->name('materias.mostrar');
        Route::get('/periodo/{id}/obtener-materias', 'PeriodosController@obtenermaterias')->name('materias.obtener');
        Route::post('/periodo/{id}/anadir-materia', 'MateriasController@anadirmateria')->name('materias.anadir');
        Route::get('/materia/{id}/eliminar', 'MateriasController@eliminarmateria')->name('materias.eliminar');
        Route::post('/materia/{id}/editar', 'MateriasController@editarmateria')->name('materias.editar');

        //cursos
        Route::get('/cursos', 'CursoController@index')->name('cursos.index');
        Route::get('/becario/{id}/crear-curso', 'CursoController@crear')->name('cursos.crear');
        Route::post('/becario/{id}/guardar-curso', 'CursoController@guardar')->name('cursos.guardar');
        Route::get('/becario/{id}/editar-curso', 'CursoController@editar')->name('cursos.editar');
        Route::post('/becario/{id}/actualizar-curso', 'CursoController@actualizar')->name('cursos.actualizar');

        //voluntariado
        Route::get('/voluntariados', 'VoluntariadoController@index')->name('voluntariados.index');
        Route::get('/becario/{id}/crear-voluntariado', 'VoluntariadoController@crear')->name('voluntariados.crear');
        Route::post('/becario/{id}/guardar-voluntariado', 'VoluntariadoController@guardar')->name('voluntariados.guardar');
        Route::get('/becario/{id}/editar-voluntariado', 'VoluntariadoController@editar')->name('voluntariados.editar');
        Route::post('/becario/{id}/actualizar-voluntariado', 'VoluntariadoController@actualizar')->name('voluntariados.actualizar');
    });

    Route::group(['middleware'=>['mentor']],function ()
    {
        Route::get('listar/becariosAsignados', [
            'uses' => 'MentorController@listarBecariosAsignados',
            'as' => 'listar.becariosAsignados'
        ]);

        Route::get('ver/miPerfilMentor', [
            'uses' => 'MentorController@verMiPerfil',
            'as' => 'ver.miPerfilMentor'
        ]);
    });

    Route::group(['middleware'=>['postulante_mentor']],function ()
    {
        Route::get('postulanteMentor/status', [
            'uses' => 'SisbecaController@statusPostulanteMentor',
            'as' => 'status.postulanteMentor'
        ]);
        Route::get('ver/miPerfil', [
            'uses' => 'SisbecaController@verMiPerfilMentor',
            'as' => 'ver.miPerfilPostulanteMentor'
        ]);
    });

    Route::group(['middleware'=>['postulante_becario']],function ()
    {
        Route::get('postulanteBecario/status', [
            'uses' => 'SisbecaController@statusPostulanteBecario',
            'as' => 'status.postulanteBecario'
        ]);
        
        Route::any('proexcelencia/enviarPostulacionGuardar/{progreso}', [
            'uses' => 'PostulanteBecarioController@enviarPostulacionGuardar',
            'as' => 'postulantebecario.enviarPostulacionGuardar'
        ]);

        Route::any('proexcelencia/enviarPostulacion', [
            'uses' => 'PostulanteBecarioController@enviarPostulacion',
            'as' => 'postulantebecario.enviarPostulacion'
        ]);

        Route::get('proexcelencia/datos-personales', [
            'uses' => 'PostulanteBecarioController@datospersonales',
            'as' => 'postulantebecario.datospersonales'
        ]);

        Route::post('proexcelencia/datos-personales/guardar', [
            'uses' => 'PostulanteBecarioController@datospersonalesguardar',
            'as' => 'postulantebecario.datospersonalesguardar'
        ]);

        Route::get('proexcelencia/estudios-secundarios', [
            'uses' => 'PostulanteBecarioController@estudiossecundarios',
            'as' => 'postulantebecario.estudiossecundarios'
        ]);

        Route::post('proexcelencia/estudios-secundarios/guardar', [
            'uses' => 'PostulanteBecarioController@estudiossecundariosguardar',
            'as' => 'postulantebecario.estudiossecundariosguardar'
        ]);
        
        Route::get('proexcelencia/estudios-universitarios', [
            'uses' => 'PostulanteBecarioController@estudiosuniversitarios',
            'as' => 'postulantebecario.estudiosuniversitarios'
        ]);

        Route::post('proexcelencia/estudios-universitarios/guardar', [
            'uses' => 'PostulanteBecarioController@estudiosuniversitariosguardar',
            'as' => 'postulantebecario.estudiosuniversitariosguardar'
        ]);

        Route::get('proexcelencia/informacion-adicional', [
            'uses' => 'PostulanteBecarioController@informacionadicional',
            'as' => 'postulantebecario.informacionadicional'
        ]);

        Route::post('proexcelencia/informacion-adicional/guardar', [
            'uses' => 'PostulanteBecarioController@informacionadicionalguardar',
            'as' => 'postulantebecario.informacionadicionalguardar'
        ]);

        Route::get('proexcelencia/documetos', [
            'uses' => 'PostulanteBecarioController@documentos',
            'as' => 'postulantebecario.documentos'
        ]);

        Route::post('proexcelencia/documentos/guardar', [
            'uses' => 'PostulanteBecarioController@documentosguardar',
            'as' => 'postulantebecario.documentosguardar'
        ]);
    });

    Route::get('perfil/{id}', [
        'uses' => 'SisbecaController@perfil',
        'as' => 'postulanteObecario.perfil'
    ]);


    Route::group(['middleware'=>'directivo'],function ()
    {
        Route::post('agregarObservacion/{id}', [
            'uses' => 'DirectivoController@agregarObservacion',
            'as' => 'agregarObservacion'
        ]);

        /*Route::any('entrevistado/{id}', [
            'uses' => 'DirectivoController@cambioStatusEntrevistado',
            'as' => 'fueAentrevista'
        ]);*/ //movido a compartido

        /*Route::any('aprobarParaEntrevista/{id}', [
            'uses' => 'DirectivoController@aprobarParaEntrevista',
            'as' => 'aprobarParaEntrevista'
        ]);*/ //movido a compartido

        Route::any('cambioStatus', [
            'uses' => 'DirectivoController@cambioStatus',
            'as' => 'cambioStatus'
        ]);

        Route::get('finalizarConcurso', [
            'uses' => 'DirectivoController@finalizarConcurso',
            'as' => 'finalizarConcurso'
        ]);
        Route::get('finalizarConcursoMentor', [
            'uses' => 'DirectivoController@finalizarConcursoMentor',
            'as' => 'finalizarConcursoMentor'
        ]);

       /* Route::get('asignarNuevoIngreso', [
            'uses' => 'DirectivoController@listarPostulantesBecarios',
            'as' => 'asignarNuevoIngreso'
        ]);

        Route::get('perfilPostulanteBecario/{id}', [
            'uses' => 'DirectivoController@perfilPostulanteBecario',
            'as' => 'perfilPostulanteBecario'
        ]);*/ //movido a compartido coord.

        Route::post('verPostulantesBecario', [
            'uses' => 'DirectivoController@verPostulantesBecario',
            'as' => 'verPostulantesBecario'
        ]);

        Route::post('verModificarEntrevistas', [
            'uses' => 'DirectivoController@modificarEntrevistas',
            'as' => 'verModificarEntrevistas'
        ]);

        /*Route::get('listarPostulantesBecarios/{data}', [
            'uses' => 'DirectivoController@listarPostulantesBecarios',
            'as' => 'listarPostulantesBecarios'
        ]);*/

        Route::post('asignacionEntrevistas', [
            'uses' => 'DirectivoController@asignacionEntrevistas',
            'as' => 'asignacionEntrevistas'
        ]);
        Route::put('postulanteMentorUpdate/{id}', [
            'uses' => 'DirectivoController@actualizarPostulanteMentor',
            'as' => 'postulanteMentor.update'
        ]);

        Route::get('listarPostulantesMentores', [
            'uses' => 'DirectivoController@listarPostulantesMentores',
            'as' => 'listarPostulantesMentores'
        ]);

        Route::any('perfilPostulantesMentores/{id}/edit', [
            'uses' => 'DirectivoController@perfilPostulantesMentores',
            'as' => 'perfilPostulantesMentores'
        ]);
        
        Route::get('nomina/generar/mes/{mes}/anho/{anho}', [
            'uses' => 'NominaController@generartodo',
            'as' => 'nomina.generar.todo'
        ]);

        Route::get('nomina/procesar', [
            'uses' => 'NominaController@procesar',
            'as' => 'nomina.procesar'
        ]);

        Route::get('nomina/procesar/mes/{mes}/anho/{anho}', [
            'uses' => 'NominaController@procesardetalle',
            'as' => 'nomina.procesar.detalle'
        ]);

        // para el servicio con vuejs
        Route::get('nomina/procesar/mes/{mes}/anho/{anho}/servicio', [
            'uses' => 'NominaController@procesardetalleservicio',
            'as' => 'nomina.procesar.detalle.servicio'
        ]);

        //servicios
        Route::get('nomina/mes/{mes}/anho/{anho}/becarios/{id}/contar-facturas', [
            'uses' => 'FactLibrosController@contarfacturaslibros',
            'as' => 'factlibros.contar'
        ]);

        //guardar CVA 
        Route::post('nomina/{id}/guardar-cva', [
            'uses' => 'NominaController@guardarcva',
            'as' => 'nomina.guardarcva'
        ]);

        Route::post('nomina/{id}/guardar-retroactivo', [
            'uses' => 'NominaController@guardarretroactivo',
            'as' => 'nomina.guardarretroactivo'
        ]);


        Route::get('nomina/procesar/mes/{mes}/anho/{anho}/becario/{id}/ver-facturas', [
            'uses' => 'FactLibrosController@verfacturas',
            'as' => 'factlibros.verfacturas'
        ]);

        Route::get('nomina/procesar/mes/{mes}/anho/{anho}/generar', [
            'uses' => 'NominaController@generar',
            'as' => 'nomina.generar'
        ]);

        Route::get('nomina/generadas', [
            'uses' => 'NominaController@listar',
            'as' => 'nomina.listar'
        ]);
        
        Route::get('nomina/generadas/mes/{mes}/anho/{anho}', [
            'uses' => 'NominaController@listarver',
            'as' => 'nomina.listar.ver'
        ]);

        Route::get('nomina/pagadas/mes/{mes}/anho/{anho}', [
            'uses' => 'NominaController@listarpagadas',
            'as' => 'nomina.listar.pagadas'
        ]);

        Route::get('nomina/pagadas', [
            'uses' => 'NominaController@pagadas',
            'as' => 'nomina.pagadas'
        ]);

        Route::get('nomina/generadas/mes/{mes}/anho/{anho}/pagar', [
            'uses' => 'NominaController@pagar',
            'as' => 'nomina.pagar'
        ]);

        Route::get('nomina/generado-pdf/mes/{mes}/anho/{anho}/', [
            'uses' => 'NominaController@generadopdf',
            'as' => 'nomina.generado.pdf'
        ]);

        Route::get('nomina/pagado-pdf/mes/{mes}/anho/{anho}/', [
            'uses' => 'NominaController@pagadopdf',
            'as' => 'nomina.pagado.pdf'
        ]);

        Route::get('nomina/cambiar-estatus', [
            'uses' => 'NominaController@cambiar',
            'as' => 'nomina.cambiar'
        ]);

        Route::get('listar/becariosGraduados', [
            'uses' => 'DirectivoController@listarBecariosGraduados',
            'as' => 'listar.becariosGraduados'
        ]);

        Route::get('listar/becariosInactivos', [
            'uses' => 'DirectivoController@listarBecariosInactivos',
            'as' => 'listar.becariosInactivos'
        ]);

        Route::get('listar/desincorporaciones', [
            'uses' => 'DirectivoController@listarDesincorporaciones',
            'as' => 'desincorporaciones.listar'
        ]);

        Route::get('desincorporacion/{user_id}/{id}/destroy', [
            'uses' => 'DirectivoController@procesarDesincorporacion',
            'as' => 'desincorporacion.procesar'
        ]);

        Route::post('validarFacturas/{mes}/{anho}/{id}', [
            'uses' => 'NominaController@validarFacturas',
            'as' => 'facturas.validar'
        ]);


     });

    Route::group(['middleware'=>'coordinador'],function ()
    {

        Route::get('gestionMentoria/asignarBecarios', [
            'uses' => 'CoordinadorController@asignarBecarios',
            'as' => 'asignarBecarios'
        ]);
		Route::get('getBecariosApi', [
            'uses' => 'CoordinadorController@getBecarios',
            'as' => 'getBecarios'
        ]);
        Route::get('getMentoresApi', [
            'uses' => 'CoordinadorController@getMentores',
            'as' => 'getMentores'
        ]);
        
         Route::get('getRelacionBecarioMentorApi', [
            'uses' => 'CoordinadorController@getRelacionBecarioMentor',
            'as' => 'getRelacionBecarioMentor'
        ]);
        Route::post('asignarRelacionBecarioMentor', 'CoordinadorController@asignarMentorBecario')->name('asignarRelacionBecarioMentor');
		Route::post('asignarMentorBecario', [
            'uses' => 'CoordinadorController@asignarMentorBecario',
            'as' => 'asignarMentorBecario'
        ]);

    });

    Route::group(['middleware'=>'compartido_direc_coord'],function ()
    {
        Route::get('listarPostulantesBecarios/{data}', [
            'uses' => 'CompartidoDirecCoordController@listarPostulantesBecarios',
            'as' => 'listarPostulantesBecarios'
        ]);
        Route::get('perfilPostulanteBecario/{id}', [
            'uses' => 'CompartidoDirecCoordController@perfilPostulanteBecario',
            'as' => 'perfilPostulanteBecario'
        ]);
        Route::any('aprobarParaEntrevista/{id}', [
            'uses' => 'CompartidoDirecCoordController@aprobarParaEntrevista',
            'as' => 'aprobarParaEntrevista'
        ]);
        Route::any('entrevistado/{id}', [
            'uses' => 'CompartidoDirecCoordController@cambioStatusEntrevistado',
            'as' => 'fueAentrevista'
        ]);
        Route::get('gestionSolicitud/listar', [
            'uses' => 'CompartidoDirecCoordController@listarSolicitudes',
            'as' => 'gestionSolicitudes.listar'
        ]);
        Route::post('veredicto/postulantesBecario', [
            'uses' => 'CompartidoDirecCoordController@veredictoPostulantesBecarios',
            'as' => 'veredicto.postulantes.becarios'
        ]);
        Route::get('postulantes/entrevistados', [
            'uses' => 'CompartidoDirecCoordController@obtener_entrevistados',
            'as' => 'postulantes.entrevistados'
        ]);

        Route::get('gestionSolicitud/revisar/{id}', [
            'uses' => 'CompartidoDirecCoordController@revisarSolicitud',
            'as' => 'solicitud.revisar'
        ]);

        Route::put('gestionSolicitud/updated/{id}', [
            'uses' => 'CompartidoDirecCoordController@gestionSolicitudUpdate',
            'as' => 'gestionSolicitud.update'
        ]);

        Route::get('becarios/listar', [
            'uses' => 'CompartidoDirecCoordController@listarBecarios',
            'as' => 'becarios.listar'
        ]);

        Route::get('mentores/listar', [
            'uses' => 'CompartidoDirecCoordController@listarMentores',
            'as' => 'mentores.listar'
        ]);

        Route::get('ver/perfilMentor/{id}', [
            'uses' => 'CompartidoDirecCoordController@verPerfilMentor',
            'as' => 'ver.perfilMentor'
        ]);

        Route::get('reporteSolicitudes', [
            'uses' => 'CompartidoDirecCoordController@solicitudespdf',
            'as' => 'reporteSolicitudes.pdf'
        ]);

        Route::get('solicitudes/formularioReporte', [
            'uses' => 'CompartidoDirecCoordController@formularioReporteSolicitudes',
            'as' => 'formularioReporte.solicitudes'
        ]);

        Route::get('SolicitudesreportePDF/{fechaDesde}/{fechaHasta}/{user_id}', [
            'uses' => 'CompartidoDirecCoordController@pdfSolicitud',
            'as' => 'solicitudes.pdf'
        ]);

        //entrevistadores
        Route::get('/asignar-entrevistadores', 'EntrevistadorController@asignarentrevistadores')->name('entrevistador.asignar');

        Route::get('/entrevistadores', 'EntrevistadorController@obtenerentrevistadores')->name('entrevistador.obtener');

        Route::post('/becario/{id}/guardar-entrevistador-asignado', 'EntrevistadorController@guardarasignarentrevistadores')->name('entrevistador.asignar.guardar');

        // postulantes 
        Route::get('/becario/postulantes', 'EntrevistadorController@obtenerpostulantes')->name('becario.obtenerpostulantes');

        //obtener becario para entrevista
    });

    Route::group(['middleware'=>'entrevistador'],function ()
    {
        Route::get('listaDeEntrevistasDePostulantes', [
            'uses' => 'EntrevistadorController@listarpostulantesaentrevistar',
            'as' => 'lista.Entrevistas.Postlantes'
        ]);  
    });

    Route::group(['middleware'=>'compartido_mentor_becario'],function ()
    {

        Route::get('solicitud/listar', [
            'uses' => 'CompartidoMentorBecarioController@listarsolicitudes',
            'as' => 'solicitud.listar'
        ]);

        Route::get('solicitud/crear-solicitud', [
            'uses' => 'CompartidoMentorBecarioController@crearsolicitud',
            'as' => 'solicitud.crear'
        ]);

        Route::get('solicitud', [
            'uses' => 'CompartidoMentorBecarioController@solicitud',
            'as' => 'solicitud.showlist'
        ]);

        Route::post('solicitud/store', [
            'uses' => 'CompartidoMentorBecarioController@solicitudStore',
            'as' => 'solicitud.store'
        ]);

        Route::get('solicitud/{id}/edit', [
            'uses' => 'CompartidoMentorBecarioController@solicitudEdit',
            'as' => 'solicitud.edit'
        ]);

        Route::put('solicitud/{id}', [
            'uses' => 'CompartidoMentorBecarioController@solicitudUpdate',
            'as' => 'solicitud.update'
        ]);

        Route::get('solicitud/{id}/destroy', [
            'uses' => 'CompartidoMentorBecarioController@solicitudDestroy',
            'as' => 'solicitud.destroy'
        ]);
    });

    Route::get('notificaciones/showAll', [
        'uses' => 'SisbecaController@allNotificaciones',
        'as' => 'notificaciones.showAll'
    ]);

});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

//esta ruta sirve para desloguear al usuario

//Route::get('/home', 'HomeController@index')->name('home');
