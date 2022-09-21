<?php

namespace App\Http\Controllers;

use App\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class CaisseController extends Controller
{

    public function index()
    {

        $annee_scolaire = Groupe::get_annee_scolaire();

        $recettes_semaines_groupe = (DB::select("select sum(payement) as montant from payment_groupes_eleves pg, groupes g where (pg.id_groupe=g.id) and (g.annee_scolaire = '$annee_scolaire') and date(pg.created_at) = date(now()) "));
        
        $recettes_semaines_groupe_special = (DB::select("select sum(payement) as montant from payement_groupe_special_eleve pg, special_groupes g where (pg.id_groupe_special=g.id) and (g.annee_scolaire = '$annee_scolaire') and (date(pg.created_at) = date(now()))"));

        $recettes_semaines_dawra = (DB::select("select sum(montant) as montant from dawrapayments where (date(created_at) = date(now())) "));
        
        $recette_frais = DB::select("select sum(frais) as montant from eleves 
            where date(updated_at)=date(now()) ");

        $sum = 0;

        foreach (array_merge($recettes_semaines_groupe,$recettes_semaines_groupe_special,$recettes_semaines_dawra,$recette_frais) as $mont) 
        {
               
            if ($mont->montant != null) 
            {

                $sum=$sum+$mont->montant;

                // code...
            }

            //
        }

        $depenses_payement_profs = DB::select("select sum(payement) as depense_payement_profs from payement_profs where date(created_at) = date(now())");
        
        $depenses_payement_profs = $depenses_payement_profs[0]->depense_payement_profs;


        $depense_autre = DB::select("select sum(montant) as depense_autre from depenses where date(created_at) = date(now())");

        $depense_autre = $depense_autre[0]->depense_autre;

        $date_debut = date('Y-m-d');
        $date_fin = date('Y-m-d');
        
        return view('Home.caisse',compact('recettes_semaines_groupe','recettes_semaines_groupe_special','recettes_semaines_dawra','recette_frais','sum','depenses_payement_profs','depense_autre','date_debut','date_fin'));

        // code...
    }

    public function ajout_depense(Request $request)
    {

        $montant = $request->montant;

        $commentaire = $request->commentaire;

        DB::insert("insert into depenses(montant,commentaire) values('$montant','$commentaire')");

        return back();

        //
    }

    public function get_recettes(Request $request)
    {

        $date_debut = $request->date_debut;
        $date_fin = $request->date_fin;

        $recettes_groupes=(DB::select("select  pg.created_at,e.id,e.nom,e.prenom,pg.payement,pg.id_groupe from payment_groupes_eleves pg, eleves e 
            where (pg.payement<>0) 
            and (pg.id_eleve=e.id) 
            and date(pg.created_at) between '$date_debut' and  '$date_fin' 
            order by pg.created_at desc,e.nom,e.prenom"));

        $recettes_dawarat = DB::select("select d.created_at,e.id,e.nom,e.prenom,d.montant as payement ,id_dawra 
            from dawrapayments d , eleves e 
            where (d.id_eleve=e.id) 
            and date(d.created_at) between '$date_debut' and  '$date_fin' 
            order by d.created_at desc,e.nom,e.prenom");
        
        $recette_frais = DB::select("select updated_at,id,nom,prenom,frais as montant 
            from eleves 
            where date(updated_at) between '$date_debut' and  '$date_fin'
            and frais <> 0 
            order by updated_at desc,nom,prenom");
        
        $recettes = (object) ['recettes_groupes'=>$recettes_groupes,'recettes_dawarat'=>$recettes_dawarat,'recette_frais'=>$recette_frais];

        return response()->json($recettes);

        // code...
    }

    public function get_depenses(Request $request)
    {

        $date_debut = $request->date_debut;
        $date_fin = $request->date_fin;

        $depenses_profs = DB::select("select p.nom,p.prenom,payement 
            from payement_profs pf, profs p 
            where (p.id=pf.id_prof) 
            and date(pf.created_at) between '$date_debut' and  '$date_fin' ");
            
        $depenses_autre = DB::select("select * 
            from depenses 
            where (date(created_at) between '$date_debut' and  '$date_fin') ");
        
        $depenses = (object)['depenses_profs'=>$depenses_profs,'depenses_autre'=>$depenses_autre];

        return response()->json($depenses);
            
        // code...
    }

    public function filter(Request $request)
    {

        $date_debut = $request->date_debut;
        $date_fin = $request->date_fin;

        $annee_scolaire = Groupe::get_annee_scolaire();

        $recettes_semaines_groupe = (DB::select("select sum(payement) as montant from payment_groupes_eleves pg, groupes g 
            where (pg.id_groupe=g.id) 
            and (g.annee_scolaire = '$annee_scolaire') 
            and ( date(pg.created_at) between '$date_debut' and  '$date_fin' ) "));
        
        $recettes_semaines_groupe_special = (DB::select("select sum(payement) as montant from payement_groupe_special_eleve pg, special_groupes g 
            where (pg.id_groupe_special=g.id) 
            and (g.annee_scolaire = '$annee_scolaire') 
            and ( date(pg.created_at) between '$date_debut' and  '$date_fin' ) "));

        $recettes_semaines_dawra = (DB::select("select sum(montant) as montant 
            from dawrapayments 
            where ( date(created_at) between '$date_debut' and  '$date_fin' ) "));
        
        $recette_frais = DB::select("select sum(frais) as montant 
            from eleves where date(updated_at) between '$date_debut' and  '$date_fin' ");

        $sum = 0;

        foreach (array_merge($recettes_semaines_groupe,$recettes_semaines_groupe_special,$recettes_semaines_dawra,$recette_frais) as $mont) 
        {
               
            if ($mont->montant != null) 
            {

                $sum=$sum+$mont->montant;

                // code...
            }

            //
        }

        $depenses_payement_profs = DB::select("select sum(payement) as depense_payement_profs from payement_profs 
            where date(created_at) between '$date_debut' and  '$date_fin' ");
        
        $depenses_payement_profs = $depenses_payement_profs[0]->depense_payement_profs;


        $depense_autre = DB::select("select sum(montant) as depense_autre from depenses 
            where date(created_at) between '$date_debut' and  '$date_fin' ");

        $depense_autre = $depense_autre[0]->depense_autre;

        $today = date('Y-m-d');
        
        return view('Home.caisse',compact('recettes_semaines_groupe','recettes_semaines_groupe_special','recettes_semaines_dawra','recette_frais','sum','depenses_payement_profs','depense_autre','date_debut','date_fin'));


        // code...
    }

    //
}
