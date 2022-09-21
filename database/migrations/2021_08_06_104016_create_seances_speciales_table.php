<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeancesSpecialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances_speciales', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_groupe_special');
            $table->double('num',8,1);
            $table->string('id_prof');
            $table->string('matiere')->nullable();
                        
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
        Schema::dropIfExists('seances_speciales');
    }
}

