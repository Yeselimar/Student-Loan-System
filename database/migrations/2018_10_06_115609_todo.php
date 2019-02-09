<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Todo extends Migration
{
    public function up()
    {
        /*Schema::create('coordinadores', function (Blueprint $table)
        {
            $table->primary('user_id'); //se coloca el mismo id porque la relacion uno a uno no pueden existir dos perfiles con el mismo user

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });*/

        Schema::create('mentores', function (Blueprint $table)
        {
            $table->primary('user_id'); //se coloca el mismo id porque la relacion uno a uno no pueden existir dos perfiles con el mismo user
            $table->enum('status',['postulante','rechazado','activo','inactivo','desincorporado'])->default('activo');
            $table->text('profesion')->nullable();
            $table->text('empresa')->nullable();
            $table->text('cargo_actual')->nullable();
            $table->text('areas_de_interes')->nullable();
            $table->datetime('fecha_ingreso_empresa')->nullable();
            $table->datetime('fecha_inactivo')->nullable();
            $table->datetime('fecha_desincorporado')->nullable();
            $table->text('observacion_inactivo')->nullable();
            $table->text('observacion_desincorporado')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('becarios', function (Blueprint $table)
        {
            $table->primary('user_id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //se coloca el mismo id porque la relacion uno a uno no pueden existir dos perfiles con el mismo user
            $table->boolean('acepto_terminos')->default(false);
            $table->enum('status',['prepostulante','postulante','no_entrevista','entrevista','entrevistado','rechazado','activo','probatorio1','probatorio2','egresado','inactivo','desincorporado'])->default('prepostulante');
            $table->double('retroactivo',20,2)->default(0);
            //Datos Personales
            $table->text('direccion_permanente')->nullable();
            $table->text('direccion_temporal')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefono_habitacion')->nullable();
            $table->string('telefono_pariente')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->double('ingreso_familiar',20,2)->nullable();
            $table->boolean('trabaja')->nullable();
            $table->string('lugar_trabajo')->nullable();
            $table->string('cargo_trabajo')->nullable();
            $table->unsignedInteger('horas_trabajo')->nullable();
            $table->boolean('contribuye_ingreso_familiar')->nullable();
            $table->float('porcentaje_contribuye_ingreso')->nullable();
            $table->enum('vives_con',['padres','otros'])->default('otros');
            $table->string('vives_otros')->nullable();
            $table->enum('tipo_vivienda',['propia','alquilada','hipotecada'])->default('propia');
            $table->unsignedInteger('composicion_familiar')->nullable();
            //Ocupacion Padre
            $table->string('ocupacion_padre')->nullable();
            $table->string('nombre_empresa_padre')->nullable();
            $table->unsignedInteger('experiencias_padre')->nullable();
            //Ocupacion Madre
            $table->string('ocupacion_madre')->nullable();
            $table->string('nombre_empresa_madre')->nullable();
            $table->unsignedInteger('experiencias_madre')->nullable();
            //Estudios Secundarios
            $table->string('nombre_institucion')->nullable();
            $table->text('direccion_institucion')->nullable();
            $table->string('director_institucion')->nullable();
            $table->string('bachiller_en')->nullable();
            $table->float('promedio_bachillerato')->nullable();
            $table->string('actividades_extracurriculares')->nullable();
            $table->string('lugar_labor_social')->nullable();
            $table->text('direccion_labor_social')->nullable();
            $table->string('supervisor_labor_social')->nullable();
            $table->text('aprendio_labor_social')->nullable();
            $table->boolean('habla_otro_idioma')->nullable();
            $table->string('habla_idioma')->nullable();
            $table->enum('nivel_idioma',['basico','medio','avanzando'])->default('basico');
            //Estudios Universitarios
            $table->dateTime('inicio_universidad')->nullable();
            $table->string('nombre_universidad')->nullable();
            $table->string('carrera_universidad')->nullable();
            $table->double('costo_matricula',20,2)->nullable();
            $table->float('promedio_universidad')->nullable();
            $table->string('periodo_academico')->nullable();
            //Informacion Adicional
            $table->enum('medio_proexcelencia',['amigo/pariente','internet','medios_comunicacion','otros'])->default('amigo/pariente');
            $table->string('otro_medio_proexcelencia')->nullable();
            $table->text('motivo_beca')->nullable();
            $table->datetime('fecha_egresado')->nullable();
            $table->datetime('fecha_inactivo')->nullable();
            $table->datetime('fecha_desincorporado')->nullable();
            $table->text('observacion_inactivo')->nullable();
            $table->text('motivo_probatorio1')->nullable();
            $table->text('motivo_probatorio2')->nullable();
            $table->text('observacion_egresado')->nullable();
            $table->text('observacion_desincorporado')->nullable();
            $table->text('cuenta_bancaria')->nullable();
            //campos para verificacion de documento
            $table->boolean('datos_personales')->default(false);
            $table->boolean('estudios_secundarios')->default(false);
            $table->boolean('estudios_universitarios')->default(false);
            $table->boolean('informacion_adicional')->default(false);
            $table->boolean('documentos')->default(false);

            //
            $table->enum('tipo',['nuevo','viejo'])->default('nuevo');
            $table->enum('regimen',['anual','semestral','trimestral'])->default('anual');
            $table->boolean('estatus_actividad');
            $table->boolean('estatus_curso');
            $table->boolean('estatus_voluntariado');



            /*$table->unsignedInteger('coordinador_id');
            $table->foreign('coordinador_id')
                ->references('user_id')->on('coordinadores')
                ->onDelete('cascade');*/

            $table->unsignedInteger('mentor_id')->nullable();
            $table->foreign('mentor_id')
                ->references('user_id')->on('mentores')
                ->onDelete('cascade');

            $table->text('observacion');//entrevistadores pone este ca|

            //campos de la entrevista
            $table->datetime('fecha_entrevista')->nullable();
            $table->time('hora_entrevista')->nullable();
            $table->text('lugar_entrevista')->nullable();
            $table->boolean('notificando_entrevista')->default(0);
            $table->datetime('fecha_notificacion_entrevista')->nullable();
            $table->text('documento_final_entrevista')->nullable();

            //campos para la nómina
            $table->datetime('fecha_ingreso')->nullable();//debe ser igual al created_at
            $table->datetime('fecha_aprobado')->nullable();//modificar cuando pasa de postulante becario a becario
            $table->datetime('fecha_egreso')->nullable();

            //campos para la bienvenida como becario
            $table->datetime('fecha_bienvenida')->nullable();
            $table->time('hora_bienvenida')->nullable();
            $table->text('lugar_bienvenida')->nullable();
            $table->text('observacion_privada')->nullable();

            //campo para control de nómina
            $table->datetime('final_carga_academica')->nullable();

            $table->timestamps();
        });

        /*
        Schema::create('entrevistadores', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre_apellido');
            $table->unsignedInteger('cedula');
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();

            $table->timestamps();
        });
        */

        Schema::create('becarios_entrevistadores', function (Blueprint $table)
        {
            $table->increments('id');

            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('entrevistador_id');
            $table->foreign('entrevistador_id')->references('id')->on('users')->onDelete('cascade');

            $table->text('documento')->nullable();
            
            $table->boolean('oculto')->default(0);

            $table->timestamps();
        });

        Schema::create('alertas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->boolean('leido')->default(false);
            $table->enum('nivel',['bajo','medio','alto'])->default('bajo');
            $table->enum('status',['enviada','generada'])->default('enviada');
            $table->unsignedInteger('solicitud')->nullable();
            $table->enum('tipo',['nomina','solicitud','justificativo','relacionbm'])->nullable()->default('solicitud');
            $table->boolean('oculto')->default(0);
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //si se borra el registro de user se borra toda la relacion de la tabla alertas

            $table->timestamps();
        });

        Schema::create('solicitudes', function (Blueprint $table)
        {
            $table->increments('id');
            $table->enum('titulo',['desincorporacion temporal','desincorporacion definitiva','reincorporacion','retroactivo','otros'])->default('otros');
            $table->text('descripcion');
            $table->text('observacion')->nullable();
            $table->enum('status',['enviada','aceptada','rechazada','cancelada'])->default('enviada');
            $table->unsignedInteger('usuario_respuesta')->nullable();
            $table->datetime('fecha_desincorporacion')->nullable();
            $table->datetime('fecha_inactividad')->nullable();
            $table->boolean('oculto_admin')->default(0);
            $table->boolean('oculto_usuario')->default(0);
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //si se borra el registro de user se borra toda la relacion de la tabla alertas

            $table->timestamps();
        });

        Schema::create('imagenes', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo');
            $table->string('url');
            $table->boolean('verificado');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('editores', function (Blueprint $table)
        {
            $table->primary('user_id'); //se coloca el mismo id porque la relacion uno a uno no pueden existir dos perfiles con el mismo user

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('noticias', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo');
            $table->string('slug');
            $table->text('contenido');
            $table->string('url_imagen');
            $table->enum('tipo',['noticia','miembroins'])->default('noticia');
            $table->string('informacion_contacto');
            $table->string('url_articulo')->nullable();
            $table->string('email_contacto')->nullable();
            $table->string('telefono_contacto')->nullable();

            $table->boolean('al_carrousel')->default(1);

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('costos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->double('sueldo_becario',20,2)->default(0);
            $table->double('costo_ases_basica',20,2)->default(0);
            $table->double('costo_ases_intermedia',20,2)->default(0);
            $table->double('costo_ases_completa',20,2)->default(0);
            $table->double('costo_membresia',20,2)->default(0);
            $table->double('costo_adicional1',20,2)->default(0);
            $table->datetime('fecha_valido')->nullable();

            $table->timestamps();
        });

        Schema::create('actividades', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');
            $table->string('anho_academico')->nullable();
            $table->enum('tipo',['taller','chat club'])->default('taller');
            $table->enum('nivel',['inicio','intermedio','avanzado','cualquier nivel'])->default('inicio');
            $table->enum('modalidad',['presencial','virtual'])->default('presencial');
            $table->text('descripcion');
            $table->unsignedInteger('limite_participantes');
            $table->unsignedInteger('horas_voluntariado');//horas en voluntariado
            $table->datetime('fecha')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->enum('status',['suspendido','bloqueado','disponible'])->default('disponible');



            $table->timestamps();
        });

        Schema::create('actividades_facilitadores', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('actividad_id');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');

        	$table->unsignedInteger('becario_id')->nullable();
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->string('nombreyapellido')->nullable();

            $table->integer('horas')->nullable();

            $table->timestamps();
        });

        Schema::create('aval', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('url');
            $table->enum('estatus',['pendiente','aceptada','negada','devuelto'])->default('pendiente');
            $table->enum('tipo',['constancia','nota','justificacion','comprobante'])->default('constancia');
            //constancia para periodos, justificacion para actividades, comprobante para voluntariados, nota para cursos.
            $table->enum('extension',['pdf','imagen'])->default('imagen');
            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('periodos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('numero_periodo');//1er semestre: según el regimen del becario
            $table->string('anho_lectivo');//2-2018
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_fin');

            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('aval_id');//constancia de notas
            $table->foreign('aval_id')->references('id')->on('aval');

            $table->timestamps();
        });

        Schema::create('materias', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');
            $table->float('nota');
            $table->unsignedInteger('periodo_id');
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('actividades_becarios',function(Blueprint $table)
        {
            $table->increments('id');

            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('actividad_id');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');

           	$table->unsignedInteger('aval_id')->nullable();
            $table->foreign('aval_id')->references('id')->on('aval');

            $table->enum('estatus',['asistira','lista de espera','justificacion cargada','asistio','no asistio'])->default('asistira');

            $table->timestamps();//fechainscripcion
        });

        Schema::create('documentos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo');
            $table->string('url');
            $table->boolean('verificado');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('factlibros', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('curso');
            $table->string('url');
            $table->double('costo',20,2);
            $table->unsignedInteger('mes')->nullable();
            $table->unsignedInteger('year')->nullable();
            $table->enum('status',['cargada','por procesar','revisada','pagada','rechazada'])->default('cargada');

            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('instituciones', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');
            $table->string('abreviatura');
            $table->text('descripcion');

            $table->timestamps();
        });

        Schema::create('voluntariados',function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');//se puede obviar y dejar solo instituto
            $table->string('instituto');
            $table->string('responsable'); // tambien llamado persona de contacto
            $table->text('observacion')->nullable();
            $table->datetime('fecha');
            $table->enum('tipo',['interno','externo'])->default('interno');
            $table->string('lugar')->nullable();//en caso de que el voluntariado externo
            $table->unsignedInteger('horas');//horas del voluntariado

        	$table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('aval_id');
            $table->foreign('aval_id')->references('id')->on('aval')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tiposcursos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->enum('tipo',['cva','otros'])->default('cva');
            $table->text('descripcion');

            $table->timestamps();
        });

        Schema::create('cursos',function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('modulo');//modulo de cva (1...15)
            $table->enum('modo',['sabatino','interdiario','diario','intensivo'])->default('sabatino');//modo cva
            $table->datetime('fecha_inicio');//fecha inicio del cva
            $table->datetime('fecha_fin');//fecha fin del cva
            $table->float('nota');//nota en ese modulo
            $table->enum('status',['aprobado','reprobado'])->default('reprobado');//verificar si este campo se mantiene

            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('tipocurso_id');
            $table->foreign('tipocurso_id')->references('id')->on('tiposcursos')->onDelete('cascade');

            $table->unsignedInteger('aval_id')->nullable();
            $table->foreign('aval_id')->references('id')->on('aval')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('notas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('promedio');
            $table->enum('status',['aprobado','reprobado'])->default('aprobado');

            $table->unsignedInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');

            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('nominas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->double('cva',20,2)->default(0);//según lo que dijo bapssy
            $table->double('retroactivo',20,2)->default(0);
            $table->double('sueldo_base',20,2)->default(0);
            $table->double('monto_libros',20,2)->default(0);
            $table->double('total',20,2)->default(0);
            $table->unsignedInteger('mes');
            $table->unsignedInteger('year');
            $table->enum('status',['pendiente', 'generado', 'pagado'])->default('pendiente');
            $table->string('datos_nombres')->nullable();
            $table->string('datos_apellidos')->nullable();
            $table->string('datos_cuenta')->nullable();
            $table->string('datos_email')->nullable();
            $table->string('datos_cedula')->nullable();
            $table->unsignedInteger('datos_id')->nullable();

            $table->timestamp('fecha_pago')->nullable();
            $table->timestamp('fecha_generada')->nullable();
            $table->timestamps();
            //crear una tabla que funcione como pivot porque tenemos una relación de muchos a muchos
        });

        Schema::create('becarios_nominas',function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('nomina_id');
            $table->foreign('nomina_id')->references('id')->on('nominas')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('nomborradores', function (Blueprint $table)
        {
            $table->increments('id');
            $table->double('sueldo_base',20,2)->default(0);
            $table->string('observacion');
            $table->unsignedInteger('mes');
            $table->unsignedInteger('year');
            $table->timestamp('fecha_generada')->nullable();

            $table->timestamps();
        });

        Schema::create('becarios_nomborradores',function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('becario_id');
            $table->foreign('becario_id')->references('user_id')->on('becarios')->onDelete('cascade');

            $table->unsignedInteger('nomborrador_id');
            $table->foreign('nomborrador_id')->references('id')->on('nomborradores')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('concursos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_final');
            $table->enum('tipo',['becarios', 'mentores'])->default('becarios');
            $table->enum('status',['abierto','cerrado','finalizado']);

            $table->timestamps();
        });

        Schema::create('desincorporaciones', function (Blueprint $table)
        {
            $table->increments('id');
            $table->enum('tipo',['sistema','solicitud'])->default('sistema');
            $table->enum('status',['ejecutada','sin ejecutar'])->default('sin ejecutar');
            $table->text('observacion')->nullable();
            $table->unsignedInteger('gestionada_por')->nullable();
            $table->unsignedInteger('user_id');
            $table->string('datos_nombres')->nullable();
            $table->string('datos_apellidos')->nullable();
            $table->string('datos_cedula')->nullable();
            $table->string('datos_email')->nullable();
            $table->string('datos_rol')->nullable();
            $table->datetime('fecha_gestionada')->nullable();

            $table->timestamps();
        });

        Schema::create('rechazados', function (Blueprint $table)
        {
            $table->increments('id');
            $table->datetime('fecha_de_participacion')->nullable();
            $table->string('cedula',15);

            $table->timestamps();
        });

        Schema::create('contactos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre_completo');
            $table->string('telefono');
            $table->string('correo');
            $table->string('asunto');
            $table->text('mensaje');

            $table->timestamps();
        });

        Schema::create('banner', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo');
            $table->string('imagen');
            $table->string('url');

            $table->timestamps();
        });

        Schema::create('charlas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('anho');
            $table->string('imagen');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('charlas');
        Schema::dropIfExists('banner');
        Schema::dropIfExists('contactos');
    	Schema::dropIfExists('rechazados');
    	Schema::dropIfExists('desincorporaciones');
    	Schema::dropIfExists('concursos');
    	Schema::dropIfExists('becarios_nomborradores');
    	Schema::dropIfExists('nomborradores');
    	Schema::dropIfExists('becarios_nominas');
    	Schema::dropIfExists('nominas');
        Schema::dropIfExists('notas');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('tiposcursos');
    	Schema::dropIfExists('voluntariados');
    	Schema::dropIfExists('instituciones');
    	Schema::dropIfExists('factlibros');
    	Schema::dropIfExists('documentos');
    	Schema::dropIfExists('actividades_becarios');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('periodos');
    	Schema::dropIfExists('aval');
    	Schema::dropIfExists('actividades_facilitadores');
    	Schema::dropIfExists('actividades');
    	Schema::dropIfExists('costos');
    	Schema::dropIfExists('noticias');
    	Schema::dropIfExists('editores');
    	Schema::dropIfExists('imagenes');
        Schema::dropIfExists('solicitudes');
        Schema::dropIfExists('alertas');
        Schema::dropIfExists('becarios');
        Schema::dropIfExists('mentores');
        /*Schema::dropIfExists('coordinadores');*/
    }
}
