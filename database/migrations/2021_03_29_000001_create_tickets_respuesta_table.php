<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tickets_respuesta', function (Blueprint $table) {
        $table->id();
        $table->longText('mensaje');

        $table->unsignedBigInteger('ticket_agregado_id');
        $table->foreign('ticket_agregado_id')->references('id')->on('tickets_agregado')->onDelete('cascade');

        $table->unsignedBigInteger('estado_id');/*visto-no visto*/
        $table->foreign('estado_id')->references('id')->on('estado')->onDelete('cascade');

        $table->unsignedBigInteger('cliente');
        $table->foreign('cliente')->references('id')->on('users')->onDelete('cascade');

        $table->unsignedBigInteger('trabajador')->nullable();
        $table->foreign('trabajador')->references('id')->on('users')->onDelete('cascade');

        $table->string('archivos')->nullable();/*si o no*/

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
      Schema::dropIfExists('tickets_respuesta');
  }
}
