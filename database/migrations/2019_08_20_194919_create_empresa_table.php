<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruc');
            $table->string('telefono');
            $table->string('celular');
            $table->string('pais');
            $table->string('departamento');
            $table->string('provincia');
            $table->string('distrito');
            $table->string('rubro');
            $table->text('descripcion');
            $table->text('pagina_web');
            $table->string('foto');

            $table->string('correo');/*Envio de Notificaciones*/
            $table->string('contrasena');/*envio de Notificaciones*/
            $table->string('encryption');/*envio de Notificaciones ssl tsl ninguno*/
            $table->string('smpt');/*envio de Notificaciones mail.sistem.com*/
            $table->string('puerto');/*envio de Notificaciones 110 25*/
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
        Schema::dropIfExists('empresa');
    }
}
