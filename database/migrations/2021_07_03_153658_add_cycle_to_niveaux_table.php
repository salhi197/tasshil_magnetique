<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCycleToNiveauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('niveaux', function (Blueprint $table) 
        {
        
            $table->string('niveau');
            $table->string('filiere');
            $table->string('cycle');

            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('niveaux', function (Blueprint $table) 
        {
        
            $table->dropColumn('niveau');
            $table->dropColumn('filiere');
            $table->dropColumn('cycle');

            //
        });
    }
}
