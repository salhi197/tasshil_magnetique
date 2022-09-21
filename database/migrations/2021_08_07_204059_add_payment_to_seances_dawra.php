<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentToSeancesDawra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seancesdawras', function (Blueprint $table) {
            $table->integer('payment')->default(0);
        });
    }

    public function down()
    {
    }
}
