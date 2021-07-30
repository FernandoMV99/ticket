<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hosting', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cliente')->nullable();
        $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

        $table->unsignedBigInteger('plan_hosting')->nullable();
        $table->foreign('plan_hosting')->references('id')->on('plan_hosting')->onDelete('cascade');


        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_vencimiento')->nullable();

        $table->string('dominio')->nullable();
        $table->string('cpanel_usuario')->nullable();
        $table->string('cpanel_password')->nullable();
        $table->string('cpanel_ip_publica')->nullable();

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
      Schema::dropIfExists('hosting');
    }
  }
