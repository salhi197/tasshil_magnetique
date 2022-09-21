<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayementGroupeSpecialElevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    
    public function up()
    {
        Schema::create('payement_groupe_special_eleve', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_groupe_special');
            $table->unsignedBigInteger('id_eleve');
            $table->string('payement');
            $table->double('num_mois',2,0);
            $table->double('num_seance',8,0);
            $table->double('exoneree',1,0)->default(0);
            $table->double('paye',1,0)->default(1);
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payement_groupe_special_eleve');
    }
}

