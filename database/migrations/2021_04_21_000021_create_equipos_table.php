<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('equipos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('marca')->nullable();
        $table->foreign('marca')->references('id')->on('marcas')->onDelete('cascade');

        $table->string('codigo_equipo')->nullable();
        $table->string('numero_serie')->nullable();
        $table->string('usuario')->nullable();

        $table->unsignedBigInteger('tipo_equipo')->nullable();
        $table->foreign('tipo_equipo')->references('id')->on('tipo_equipo')->onDelete('cascade');

        $table->unsignedBigInteger('cliente')->nullable();
        $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

        $table->string('descripcion_hardware')->nullable();

        $table->unsignedBigInteger('user_registrado')->nullable();
        $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');

        $table->string('estado_soporte')->default("1");/*si esta registrado parte del soporte 1=no asignado  0= asignado */
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
      Schema::dropIfExists('equipos');
    }
  }
