<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupeSpecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_groupes', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            
            $table->time('heure_debut', $precision = 0);
            $table->time('heure_fin', $precision = 0);
            $table->double('pourcentage_prof',8,1);
            $table->string('pourcentage_ecole', $precision = 0);
            $table->string('annee_scolaire');
            $table->double('tarif',8,1);

            $table->string('salle');            
            $table->string('niveau');
            $table->integer('visible')->default(1);
                        
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
        Schema::dropIfExists('special_groupes');
    }
}

