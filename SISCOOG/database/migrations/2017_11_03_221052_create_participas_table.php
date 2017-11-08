<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idGrupo')->unsigned();
            $table->integer('idUsuario')->unsigned();
            $table->foreign('idGrupo')->references('id')->on('grupos')->onDelete('cascade');
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
        Schema::drop('participas');
    }
}
