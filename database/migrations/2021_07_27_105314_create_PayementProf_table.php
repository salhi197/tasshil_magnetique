<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayementProfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('payement_profs', function (Blueprint $table) 
        
        {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_prof');
            $table->unsignedBigInteger('id_groupe');
            $table->unsignedBigInteger('num_mois');
            $table->unsignedBigInteger('num_seance');
            $table->double('payement',8,2);
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

        Schema::dropIfExists('payement_profs');
        
        //
    }
}

