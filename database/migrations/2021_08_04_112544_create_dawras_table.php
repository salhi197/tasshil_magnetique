<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDawrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dawras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prof');
            $table->string('niveau');
            $table->string('matiere');
            $table->integer('nbrseances');
            $table->string('pourcentage_prof', $precision = 0)->nullable();
            $table->string('pourcentage_ecole', $precision = 0)->nullable();
            $table->double('tarif',8,1);            
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
        Schema::dropIfExists('dawras');
    }
}
