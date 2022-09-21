<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumMoisToPaymentGroupesElevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_groupes_eleves', function (Blueprint $table) 
        {   

            $table->integer('num_mois')->default(1);
            
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
        Schema::table('payment_groupes_eleves', function (Blueprint $table) 
        {

            $table->dropColumn('num_mois');
            //
        });
    }
}
