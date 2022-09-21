<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeancesdawrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seancesdawras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_eleve');
            $table->integer('id_dawra');
            $table->integer('num_seance');
            $table->string('presence');
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
        Schema::dropIfExists('seancesdawras');
    }
}
