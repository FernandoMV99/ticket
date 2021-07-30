<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorDominiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('proveedor_dominios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('descripcion')->nullable();
        $table->string('correo')->nullable();
        $table->string('estado')->nullable();

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
      Schema::dropIfExists('proveedor_dominios');
  }
}
