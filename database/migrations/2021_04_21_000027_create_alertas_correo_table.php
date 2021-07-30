<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertasCorreoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('alertas_correo', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('usuario')->nullable();
        $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');

        $table->string('fecha1')->nullable();
        $table->string('fecha2')->nullable();
        $table->string('fecha3')->nullable();

        $table->string('estado_fecha1')->default("0");/*0=no recibido - 1=enviado*/
        $table->string('estado_fecha2')->default("0");/*0=no recibido - 1=enviado*/
        $table->string('estado_fecha3')->default("0");/*0=no recibido - 1=enviado*/

        $table->string('nombre_html_sms')->nullable();
        $table->string('nombre_modelo')->nullable();
        $table->string('id_registro')->nullable();

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
      Schema::dropIfExists('alertas_correo');
    }
  }
