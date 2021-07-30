<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDominiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('dominios', function (Blueprint $table) {
        $table->id();
        $table->date('fecha_compra')->nullable();
        $table->date('fecha_vencimiento')->nullable();
        $table->string('nombre_dominio')->nullable();

        $table->unsignedBigInteger('cliente')->nullable();
        $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

        $table->unsignedBigInteger('proveedor')->nullable();
        $table->foreign('proveedor')->references('id')->on('proveedor_dominios')->onDelete('cascade');

        $table->unsignedBigInteger('plan_domi')->nullable();
        $table->foreign('plan_domi')->references('id')->on('plan_dominio')->onDelete('cascade');

        $table->string('descripcion')->nullable();

        $table->string('moneda')->nullable();

        $table->string('precio')->nullable();
        $table->string('estado')->nullable();

        $table->string('anos')->nullable();

        $table->unsignedBigInteger('user_registrado')->nullable();
        $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');


        $table->string('estado_anulado')->nullable();
        $table->string('estado_pagado')->default(0);/*Si se pago el producto*/

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
      Schema::dropIfExists('dominios');
    }
  }
