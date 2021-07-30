<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class  CreateSoporteTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('soporte_tecnico', function (Blueprint $table) {
       $table->id();

       $table->unsignedBigInteger('cliente')->nullable();
       $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

       $table->string('cantidad_equipos')->default("0");
       $table->string('cantidad_equipos_asignados')->default("0");

       $table->string('moneda')->nullable();
       $table->string('precio')->nullable();
       $table->string('anos')->nullable();

       $table->date('fecha_inicio')->nullable();
       $table->date('fecha_vencimiento')->nullable();

       $table->unsignedBigInteger('user_registrado')->nullable();
       $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');

       $table->unsignedBigInteger('plan_soporte')->nullable();
       $table->foreign('plan_soporte')->references('id')->on('plan_soporte_tecnico')->onDelete('cascade');

       $table->string('descripcion')->nullable();

       $table->string('estado_pagado')->default(0);/*Si se pago el producto*/
       $table->string('estado')->default("0");
       $table->string('estado_anulado')->default("0");
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
      Schema::dropIfExists('soporte_tecnico');
    }
  }
