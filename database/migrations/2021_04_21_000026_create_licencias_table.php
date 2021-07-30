<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('licencias', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('cliente')->nullable();
        $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

        $table->unsignedBigInteger('equipo')->nullable();
        $table->foreign('equipo')->references('id')->on('equipos')->onDelete('cascade');

        $table->string('nombre')->nullable();
        $table->string('codigo_licencia')->nullable();
        $table->string('descripcion')->nullable();

        $table->unsignedBigInteger('categoria_licencia')->nullable();
        $table->foreign('categoria_licencia')->references('id')->on('categoria_licencia')->onDelete('cascade');


        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_vencimiento')->nullable();

        $table->string('moneda')->nullable();
        $table->string('precio')->nullable();
        $table->string('anos')->nullable();

        $table->string('estado')->default(0);
        $table->string('estado_anulado')->default(0);
        $table->string('estado_pagado')->default(0);/*Si se pago el producto*/

        $table->unsignedBigInteger('user_registrado')->nullable();
        $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');

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
      Schema::dropIfExists('licencias');
    }
  }
