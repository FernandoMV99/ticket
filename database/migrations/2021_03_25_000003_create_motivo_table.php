<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');

            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estado')->onDelete('cascade');

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
        Schema::dropIfExists('motivo');
    }
}
