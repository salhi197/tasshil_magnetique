<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDawraelevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dawraeleves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_eleve')->nullable();
            $table->integer('id_dawra')->nullable();
            $table->integer('paye')->nullable();
            $table->integer('payment')->nullable();
            $table->integer('reste')->nullable();
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
        Schema::dropIfExists('dawraeleves');
    }
}
