<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDawrapaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('dawrapayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_eleve');
            $table->integer('id_dawra');
            $table->integer('montant');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dawrapayments');
    }
}
