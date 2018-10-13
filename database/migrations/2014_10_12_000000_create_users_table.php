<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('achternaam');
            $table->string('voornaam');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('organisatieonderdeel');
            $table->string('telefoonnummermobiel');
            $table->string('telefoonnummervast');
            $table->string('achtervang');
            $table->string('werktijden');
            $table->string('kamer');
            $table->text('overmij');
            $table->text('taken');
            $table->text('rctoken');
            $table->text('rcusername');
            $table->text('rcid');
            $table->rememberToken();
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
