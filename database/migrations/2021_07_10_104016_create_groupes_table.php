<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupes', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            
            $table->time('heure_debut', $precision = 0);
            $table->time('heure_fin', $precision = 0);
            $table->string('pourcentage_prof', $precision = 0);
            $table->string('pourcentage_ecole', $precision = 0);
            $table->string('annee_scolaire');


            $table->string('classe');
            $table->string('prof');
            $table->string('niveau');
            $table->string('matiere');
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

/*            $table->foreign('id_classe')->references('id')->on('classes');
            $table->foreign('id_prof')->references('id')->on('profs');
            $table->foreign('id_niveau')->references('id')->on('niveaux');
            $table->foreign('id_matiere')->references('id')->on('id_matiere');
*/        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupes');
    }
}
