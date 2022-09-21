<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    
    public function up()
    {

        Schema::create('Classes', function (Blueprint $table) 
        
        {

            $table->bigIncrements('id');
            $table->string('num');
            $table->string('nb_places_min');
            $table->string('nb_places_max');
            $table->timestamp('created_at')->useCurrent();

            //
        });        

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('classes');

        //
    }
}
