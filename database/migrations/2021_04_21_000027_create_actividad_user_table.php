<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('actividad_user', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('usuario')->nullable();
        $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');

        $table->string('cantidad')->nullable();
        $table->string('fecha')->nullable();

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
      Schema::dropIfExists('actividad_user');
    }
  }
