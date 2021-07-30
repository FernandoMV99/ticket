<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('software_equipo', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_programa')->nullable();
        $table->string('cod_licencia')->nullable();

        $table->string('id_licencia')->nullable();

        $table->unsignedBigInteger('equipos')->nullable();
        $table->foreign('equipos')->references('id')->on('equipos')->onDelete('cascade');

        $table->unsignedBigInteger('user_registrado')->nullable();
        $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');

        $table->string('comprado_aqui')->nullable();/*Si le vendimos el Programa*/

        $table->string('estado')->default("0");
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
      Schema::dropIfExists('software_equipo');
    }
  }
