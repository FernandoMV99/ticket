<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('num_indentificacion')->nullable();
            $table->string('empresa')->nullable();

            $table->unsignedBigInteger('documento_identificacion')->nullable();
            $table->foreign('documento_identificacion')->references('id')->on('documento_identificacion')->onDelete('cascade');

            $table->string('numero_identificacion')->nullable();
            $table->string('celular')->nullable();

            $table->string('pais')->nullable();
            $table->string('departamento')->nullable();
            $table->string('direccion')->nullable();

            $table->string('email')->unique();
            $table->string('email2')->nullable();
            $table->string('password');
            $table->string('codigo_confirmacion')->nullable();

            $table->unsignedBigInteger('estado_confirmado')->nullable();
            $table->foreign('estado_confirmado')->references('id')->on('estado')->onDelete('cascade');

            $table->unsignedBigInteger('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('estado_activo');
            $table->foreign('estado_activo')->references('id')->on('estado')->onDelete('cascade');

            $table->string('foto')->nullable();

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
        Schema::dropIfExists('users');
    }
}
