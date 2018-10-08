<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposTablaColaborators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colaborators', function(Blueprint $table){
            $table->string('nombre', 45);
            $table->string('apellido', 45);
            $table->integer('edad');
            $table->integer('dni');
            $table->integer('legajo');
            $table->string('puesto', 45);
            $table->string('mail', 80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colaborators', function(Blueprint $table){
            $table->dropColumn('id');
        });
    }
}
