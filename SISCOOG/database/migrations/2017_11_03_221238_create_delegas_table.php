<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegas', function (Blueprint $table) {
            $table->integer('idGrupo')->unsigned();
            $table->integer('idTarefa')->unsigned();
            $table->integer('idUsuario')->unsigned();
            $table->foreign('idGrupo')->references('id')->on('grupos');
            $table->foreign('idTarefa')->references('id')->on('tarefas')->onDelete('cascade');
            $table->foreign('idUsuario')->references('id')->on('users');
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
        Schema::drop('delegas');
    }
}
