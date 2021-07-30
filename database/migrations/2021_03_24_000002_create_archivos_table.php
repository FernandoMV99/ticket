<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('archivos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('tabla_bd');
        $table->string('tabla_id_bd');
        $table->string('carpeta')->nullable();
        $table->string('extension')->nullable();

        $table->unsignedBigInteger('estado_id');
        $table->foreign('estado_id')->references('id')->on('estado')->onDelete('cascade');

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
      Schema::dropIfExists('imagenes');
    }
  }
