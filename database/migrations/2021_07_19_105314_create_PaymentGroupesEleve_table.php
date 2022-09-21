<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGroupesEleveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('payment_groupes_eleves', function (Blueprint $table) 
        
        { 

            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_groupe');
            $table->unsignedBigInteger('id_eleve');
            $table->unsignedBigInteger('num_seance');
            $table->string('payement');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_groupe')->references('id')->on('groupes');
            $table->foreign('id_eleve')->references('id')->on('eleves');

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

        Schema::dropIfExists('payment_groupes_eleves');
        
        //
    }
}
