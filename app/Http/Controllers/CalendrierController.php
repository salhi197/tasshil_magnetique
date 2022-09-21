<?php

namespace App\Http\Controllers;

use App\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class CalendrierController extends Controller
{

    function cmp($a, $b) 
    {
        return strcmp($a->heure_debut, $b->heure_debut);
    }

    public function index()
    {


        $salles = DB::select("select * from classes where visible = 1 order by num");

        $salles_profs_dimanche = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Dimanche' order by classe,heure_debut"));
        
        $salles_profs_dimanche1 = (DB::select("select salle as classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Dimanche' order by classe,heure_debut"));

        $salles_profs_dimanche = array_merge($salles_profs_dimanche,$salles_profs_dimanche1);

        usort($salles_profs_dimanche, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});

        $horaires_dimanche = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Dimanche' order by heure_debut"));

        $horaires_dimanche1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Dimanche' order by heure_debut"));

        $horaires_dimanche = array_unique(array_merge($horaires_dimanche,$horaires_dimanche1), SORT_REGULAR);        
        
        /*****************************************************************************/

        $salles_profs_lundi = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Lundi' order by classe,heure_debut"));

        $salles_profs_lundi1 = (DB::select("select salle as classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Lundi' order by classe,heure_debut"));
        
        $salles_profs_lundi = array_merge($salles_profs_lundi,$salles_profs_lundi1);

        usort($salles_profs_lundi, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});

        $horaires_lundi = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Lundi' order by heure_debut"));

        $horaires_lundi1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Lundi' order by heure_debut"));

        $horaires_lundi = array_unique(array_merge($horaires_lundi,$horaires_lundi1), SORT_REGULAR);


        /*****************************************************************************/

        $salles_profs_mardi = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Mardi' order by classe,heure_debut"));

        $salles_profs_mardi1 = (DB::select("select salle as classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Mardi' order by classe,heure_debut"));

        $salles_profs_mardi = array_merge($salles_profs_mardi,$salles_profs_mardi1);

        usort($salles_profs_mardi, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});
        
        $horaires_mardi = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Mardi' order by heure_debut"));

        $horaires_mardi1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Mardi' order by heure_debut"));

        $horaires_mardi = array_unique(array_merge($horaires_mardi,$horaires_mardi1), SORT_REGULAR);

        /*****************************************************************************/

        $salles_profs_mercredi = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Mercredi' order by classe,heure_debut"));
        
        $salles_profs_mercredi1 = (DB::select("select salle as  classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Mercredi' order by classe,heure_debut"));

        $salles_profs_mercredi = array_merge($salles_profs_mercredi,$salles_profs_mercredi1);

        usort($salles_profs_mercredi, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});

        $horaires_mercredi = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Mercredi' order by heure_debut"));

        $horaires_mercredi1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Mercredi' order by heure_debut"));

        $horaires_mercredi = array_unique(array_merge($horaires_mercredi,$horaires_mercredi1), SORT_REGULAR);

        /****************************************************************************/

        $salles_profs_jeudi = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Jeudi' order by classe,heure_debut"));
        
        $salles_profs_jeudi1 = (DB::select("select salle as classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Jeudi' order by classe,heure_debut"));

        $salles_profs_jeudi = array_merge($salles_profs_jeudi,$salles_profs_jeudi1);

        usort($salles_profs_jeudi, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});

        $horaires_jeudi = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Jeudi' order by heure_debut"));

        $horaires_jeudi1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Jeudi' order by heure_debut"));

        $horaires_jeudi = array_unique(array_merge($horaires_jeudi,$horaires_jeudi1), SORT_REGULAR);

        /****************************************************************************/

        $salles_profs_vendredi = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Vendredi' order by classe,heure_debut"));

        $salles_profs_vendredi1 = (DB::select("select salle as classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Vendredi' order by classe,heure_debut"));

        $salles_profs_vendredi = array_merge($salles_profs_vendredi,$salles_profs_vendredi1);

        usort($salles_profs_vendredi, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});
        
        $horaires_vendredi = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Vendredi' order by heure_debut"));

        $horaires_vendredi1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Vendredi' order by heure_debut"));

        $horaires_vendredi = array_unique(array_merge($horaires_vendredi,$horaires_vendredi1), SORT_REGULAR);

        /***************************************************************************/

        $salles_profs_samedi = (DB::select("select classe,matiere,prof,heure_debut,heure_fin,niveau from groupes where visible = 1 and jour = 'Samedi' order by classe,heure_debut"));
        
        $salles_profs_samedi1 = (DB::select("select salle as classe,heure_debut,heure_fin,niveau from special_groupes where visible = 1 and jour = 'Samedi' order by classe,heure_debut"));

        $salles_profs_samedi = array_merge($salles_profs_samedi,$salles_profs_samedi1);

        usort($salles_profs_samedi, function($a, $b) {return strcmp($a->heure_debut, $b->heure_debut);});

        $horaires_samedi = (DB::select("select distinct heure_debut,heure_fin from groupes where visible = 1 and jour = 'Samedi' order by heure_debut"));

        $horaires_samedi1 = (DB::select("select distinct heure_debut,heure_fin from special_groupes where visible = 1 and jour = 'Samedi' order by heure_debut"));

        $horaires_samedi = array_unique(array_merge($horaires_samedi,$horaires_samedi1), SORT_REGULAR);

        /*****************************************************************************/

        return view('Home.calendrier',compact('salles','salles_profs_dimanche','horaires_dimanche','salles_profs_lundi','horaires_lundi','salles_profs_mardi','horaires_mardi','salles_profs_mercredi','horaires_mercredi','salles_profs_jeudi','horaires_jeudi','salles_profs_vendredi','horaires_vendredi','salles_profs_samedi','horaires_samedi'));

        // code...
    }

    //
}
