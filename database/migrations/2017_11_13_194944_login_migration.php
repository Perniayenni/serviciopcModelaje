<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoginMigration extends Migration
{

    public function up()
    {
        Schema::create('login', function (Blueprint $table) {
            $table->increments('id_login');
            $table->string('Nombre');
            $table->string('apellido');
            $table->string('usuario');
            $table->string('contrasena');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('login');
    }
}
