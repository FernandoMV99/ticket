<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEquipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tipo_equipo', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('imagen')->nullable();
        $table->string('estado')->default("0");
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
      Schema::dropIfExists('tipo_equipo');
    }
  }
