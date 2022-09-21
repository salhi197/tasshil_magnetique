<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatricules extends Migration
{

    public function up()
    {
        Schema::create('matricules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_eleve');
            $table->unsignedBigInteger('id_groupe');
            $table->bigInteger('matricule');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matricules');
    }
}
