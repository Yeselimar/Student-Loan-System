<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Estipendios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estipendios', function (Blueprint $table)
        {
            $table->increments('id');
            $table->double('estipendio',20,2)->default(0);
            $table->unsignedInteger('mes');
            $table->unsignedInteger('anio');
            $table->boolean('usado_en_nomina')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estipendios');
    }
}
