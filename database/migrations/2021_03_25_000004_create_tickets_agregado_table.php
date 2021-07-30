<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsAgregadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tickets_agregado', function (Blueprint $table) {
        $table->id();
        $table->string('codigo_ticket');/*T-000001*/
        $table->string('asunto');
        $table->longText('mensaje');

        $table->unsignedBigInteger('estado_id');/*visto-no visto*/
        $table->foreign('estado_id')->references('id')->on('estado')->onDelete('cascade');

        $table->unsignedBigInteger('motivo_id');
        $table->foreign('motivo_id')->references('id')->on('motivo')->onDelete('cascade');

        $table->unsignedBigInteger('cliente')->nullable();
        $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

        $table->unsignedBigInteger('trabajador')->nullable();
        $table->foreign('trabajador')->references('id')->on('users')->onDelete('cascade');

        $table->string('equipo')->nullable();

        $table->string('archivos')->nullable();/*si o no*/

        /*Estado pagado-Nota de Venta*/
        $table->string('moneda')->nullable();
        $table->string('precio')->nullable();
        $table->string('estado_enviado_notificacion')->default(0);/*Si se envio la notificacion*/
        $table->string('estado_pagado')->default(0);/*Si se pago el soporte*/

        $table->boolean('estado_resuelto');
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
      Schema::dropIfExists('tickets_agregado');
    }
  }
