<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostingCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hosting_correos', function (Blueprint $table) {
        $table->id();

        $table->string('correo')->nullable();
        $table->string('contrasena')->nullable();
        $table->string('servidor_entrante')->nullable();
        $table->string('servidor_entrante_imap')->default("993");
        $table->string('servidor_entrante_pop')->default("995");
        $table->string('servidor_salida')->nullable();
        $table->string('servidor_salida_smptp')->default("465");

        $table->unsignedBigInteger('hosting_id')->nullable();
        $table->foreign('hosting_id')->references('id')->on('hosting')->onDelete('cascade');


        $table->unsignedBigInteger('user_registrado')->nullable();
        $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');

        $table->string('estado_borrado')->default("0");
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
      Schema::dropIfExists('hosting_correos');
  }
}
