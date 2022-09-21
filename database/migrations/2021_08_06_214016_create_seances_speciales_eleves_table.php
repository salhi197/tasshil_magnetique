<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeancesSpecialesElevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances_speciales_eleves', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_seance_speciale');
            $table->unsignedBigInteger('id_eleve');
            $table->double('presence',1,0)->default(0);
                        
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
        Schema::dropIfExists('seances_speciales_eleves');
    }
}

