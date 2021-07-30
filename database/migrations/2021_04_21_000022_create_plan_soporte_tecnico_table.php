<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class  CreatePlanSoporteTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('plan_soporte_tecnico', function (Blueprint $table) {
       $table->id();

       $table->string('nombre')->nullable();

       $table->string('descripcion')->nullable();

       $table->unsignedBigInteger('user_registrado')->nullable();
       $table->foreign('user_registrado')->references('id')->on('users')->onDelete('cascade');

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
      Schema::dropIfExists('plan_soporte_tecnico');
    }
  }
