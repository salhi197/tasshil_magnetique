<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_groupe');
            $table->unsignedBigInteger('num');
            $table->timestamp('created_at')->useCurrent();
//            $table->foreign('id_groupe')->references('id')->on('groupes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
}
