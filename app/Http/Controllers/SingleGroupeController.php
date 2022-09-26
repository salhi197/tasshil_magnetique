<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Eleve;
use App\Seanceseleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\rt\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SingleGroupeController extends Controller
{

    public function valider_coches(Request $request)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');

        ini_set('max_input_vars','5500');

        $data = $request->all();
        
        $eleves_groupe = $data["eleves_groupe"];
        $groupe = $data["groupe"];
        $numero_de_la_seance_dans_le_mois = $data["numero_de_la_seance_dans_le_mois"];
        $les_coches = $data["les_coches"];
        if(count($data)>5)
        {

            $eleves_gratuits = $data["eleves_gratuits"];
        }
        else
            $eleves_gratuits = [];
        
        $id_groupe = $groupe;

        $le_mois = Groupe::get_the_month($id_groupe);

        if(!empty($data["les_input_payement"]))
        {
            $les_input_payement = $data["les_input_payement"];
        }

        $id_dernier_seance_du_groupe = (DB::select("select max(id) as id_derniere_seance from seances where id_groupe = \"$id_groupe\" "));
        
        $num_seance_groupe = DB::select("select max(num) as numero_de_la_derniere_seance_du_groupe from seances where id_groupe = \"$id_groupe\" ");

        $num_seance_groupe = $num_seance_groupe[0]->numero_de_la_derniere_seance_du_groupe;

        $seance_prochaine = $num_seance_groupe+1;

        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
            //
        }


        DB::insert("insert into seances (id_groupe,num) values (\"$id_groupe\",\"$seance_prochaine\" ) ");
        
        $last = DB::select("select max(id) as last_id from seances where id_groupe = \"$id_groupe\" ");
        
        $last_id_seance = $last[0]->last_id;

        for ($i=0; $i<count($les_coches); $i++) 
        {
            
            $presence = $les_coches[$i];

            $id_eleve = (int)$eleves_groupe[$i]["id"]; 

            if($les_input_payement[$i]==null)
            {
                $payement = 0;
            }
            else
            {
                $payement = $les_input_payement[$i];   
            }
            
            $now=(DB::select("select now() as datetime"));

            $now = $now[0]->datetime;

            $esq_gratuit = 0;

            foreach ($eleves_gratuits as $eleve_gratuit) 
            {
                
                if ($eleve_gratuit['id_eleve'] == $id_eleve ) 
                {

                    if ($presence == 1) 
                    {
                        
                        (DB::update("update seances_eleves set presence = 2 ,num_seance =num_seance+1,created_at = \"$now\"  where id_eleve = \"$id_eleve\" and id_seance = \"$id_dernier_seance_du_groupe\" "));

                        //
                    }
                    elseif($presence == 0)
                    {

                        (DB::update("update seances_eleves set presence = 0 ,num_seance =num_seance+1,created_at = \"$now\"  where id_eleve = \"$id_eleve\" and id_seance = \"$id_dernier_seance_du_groupe\" "));

                        //
                    }


                    $esq_gratuit++;

                    // code...
                }

                //
            }

            if ($esq_gratuit==0) 
            {
                
                (DB::update("update seances_eleves set presence = \"$presence\" ,num_seance =num_seance+1,created_at = \"$now\"  where id_eleve = \"$id_eleve\" and id_seance = \"$id_dernier_seance_du_groupe\" "));
                
                // code...
            }


            (DB::insert("insert into seances_eleves(num_seance,paye,payement,id_seance,id_eleve) values(\"$num_seance_groupe\",1,2000,\"$last_id_seance\",\"$id_eleve\") "));
    
            if(!empty($data["les_input_payement"]))
            {

                (DB::insert("insert into payment_groupes_eleves(id_groupe,id_eleve,num_seance,payement,num_mois) values(\"$id_groupe\",\"$id_eleve\",\"$num_seance_groupe\",\"$payement\",\"$le_mois\") "));
            }

            // code...
        }

        
        // code...
    }

    public function historique_payement($id_groupe,$id_eleve)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');


        $groupe = DB::select("select * from groupes where id = \"$id_groupe\" ");
        $groupe = $groupe[0];
        
        $eleve = DB::select("select * from eleves where id = \"$id_eleve\" ");
        $eleve = $eleve[0];
        
        $le_mois = Groupe::get_the_month($id_groupe);

        $payement_eleve = DB::select("select * from payment_groupes_eleves where id_eleve = \"$id_eleve\" and id_groupe=\"$id_groupe\" and payement <> 0 order by num_mois,created_at ");

        $seances_eleves = DB::select("select se.id_eleve,se.presence,s.num,se.created_at from seances_eleves se, seances s where (se.id_seance=s.id) and (s.id_groupe = \"$id_groupe\") and (id_eleve = \"$id_eleve\") order by s.num ");
        
        $les_presences = DB::select("select se.id_eleve,FLOOR((s.num-1)/4)+1 as mois,count(presence) as presences from seances_eleves se,seances s where (se.id_seance = s.id) and (se.id_eleve = \"$id_eleve\") and (s.id_groupe = \"$id_groupe\") and (se.presence = 1) group by se.id_eleve,s.num");

        $les_absences = DB::select("select se.id_eleve,FLOOR((s.num-1)/4)+1 as mois,count(presence) as presences from seances_eleves se,seances s where (se.id_seance = s.id) and (se.id_eleve = \"$id_eleve\") and (s.id_groupe = \"$id_groupe\") and (se.presence = 0) group by se.id_eleve,s.num");

        //dump($les_absences);
        //dd($les_presences);

        $retards = DB::select("select pg.id_eleve,pg.id_groupe,pg.num_mois,sum(payement) as payment_du_mois,sum(exoneree) as exoneree from payment_groupes_eleves pg where id_groupe =\"$id_groupe\"  and pg.id_eleve=\"$id_eleve\" group by pg.id_eleve,pg.id_groupe,pg.num_mois order by id_eleve,num_mois"); 

        $current = (Groupe::current_seance($groupe->id));
        
        $num_seance_groupe = DB::select("select max(num) as numero_de_la_derniere_seance_du_groupe from seances where id_groupe = \"$id_groupe\" ");

        $num_seance_groupe = $num_seance_groupe[0]->numero_de_la_derniere_seance_du_groupe;

        $frais = DB::select("select frais from ecoles");

        $frais = $frais[0]->frais;

        $autres_groupes = (Eleve::get_allgroupes_of_one_eleve($id_eleve,$id_groupe));

        return view('Home.single_eleve',compact('groupe','eleve','payement_eleve','seances_eleves','le_mois','les_presences','les_absences','retards','current','num_seance_groupe','frais','autres_groupes'));

        // code...
    }

    public function exonerer(Request $request)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');


        $data = ($request->all());
            
        $id_groupe = $data["id_groupe"];
        $id_eleve = $data["id_eleve"];
        $num_mois = $data["num_mois"];

        dump(DB::update("update payment_groupes_eleves set exoneree = 1 where (id_groupe = \"$id_groupe\") and (id_eleve = \"$id_eleve\") and (num_mois=\"$num_mois\")"));

        // code..
    }   

    public function completer_payement(Request $request)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');


        $data = ($request->all());

        $id_groupe = $data["id_groupe"];
        $id_eleve = $data["id_eleve"];
        $current_seance = $data["current_seance"];
        $payement = $data["payement"];
        $num_mois = $data["num_mois"];
        
        dump(DB::insert("insert into payment_groupes_eleves(id_groupe,id_eleve,num_seance,payement,num_mois) values(\"$id_groupe\",\"$id_eleve\",\"$current_seance\",\"$payement\",\"$num_mois\") "));
        
        //
    }

    public function toutes_seances($id_groupe)
    {

        $id=($id_groupe);

        set_time_limit(0);

        ini_set('memory_limit', '-1');

        $groupe = (DB::select("select * from groupes where id = \"$id\" "));

        $groupe = $groupe[0];

        $this_mois = (Groupe::get_the_month($groupe->id));
        
        $seances_eleves = DB::select("select e.id as id_eleve,s.id_groupe,s.num as numero_de_la_seance_dans_le_mois,se.presence,se.created_at from seances s , seances_eleves se , eleves e where (s.id_groupe = \"$id\") and (se.id_seance=s.id) and (se.id_eleve = e.id) /*and ((FLOOR((s.num-1)/4)+1)=\"$this_mois\" or (FLOOR((s.num-1)/4)+1)=\"$this_mois-1\" or (FLOOR((s.num-1)/4)+1)=\"$this_mois+1\" )*/ order by e.nom,e.prenom,s.num");
        
        $eleves_groupe = DB::select("select DISTINCT e.id,e.nom,e.prenom,e.num_tel from eleves e, payment_groupes_eleves p where ( p.id_groupe = \"$id\"  and p.id_eleve=e.id ) order by e.nom,e.prenom ");
        
        $nbr_seance_mois = (DB::select("select num as numero_de_la_seance_dans_le_mois from seances where id_groupe = \"$id\" order by num desc "));

        if (count($nbr_seance_mois)>0) 
        {

            $numero_de_la_seance_dans_le_mois=$nbr_seance_mois[0]->numero_de_la_seance_dans_le_mois;

            // code...
        }
        else
        {

            $numero_de_la_seance_dans_le_mois=0;

            //
        }
        
        $le_mois = (Groupe::get_the_month($id));

        $payments = DB::select("select id_eleve,id_groupe,num_mois,sum(payement) as payment_du_mois from payment_groupes_eleves where id_groupe =\"$id\" and num_mois = \"$le_mois\" group by id_eleve,id_groupe,num_mois order by id_eleve,num_mois"); 

        /*dd($payments);*/

        $ancien_payments = DB::select("select pg.id_eleve,pg.id_groupe,pg.num_mois,sum(payement) as payment_du_mois,sum(exoneree) as exoneree from payment_groupes_eleves pg where id_groupe =\"$id\" and num_mois <> \"$le_mois\" group by pg.id_eleve,pg.id_groupe,pg.num_mois having (sum(payement) <> (select tarif from groupes where id = \"$id\") ) order by id_eleve,num_mois"); 

        //dd($ancien_payments);

        $nb_presences = (DB::select("select FLOOR((s.num-1)/4)+1 as num_mois,count(se.presence) as nb_presence from seances_eleves se, seances s where(se.id_seance=s.id) and (s.id_groupe=\"$id\") and (se.presence = 1) group by FLOOR((s.num-1)/4)+1 "));

        $nom_prenom = (explode('-',$groupe->prof));
        
        $nom = $nom_prenom[0];
        $prenom = $nom_prenom[1];
        
        $numtel = DB::select("select nom,prenom,tel from profs where (nom = \"$nom\" and prenom = \"$prenom\") or (nom = \"$prenom\" and prenom = \"$nom\") ");
        
        $numtel = $numtel[0];

        return view('Home.single_groupe_complet',compact('groupe','eleves_groupe','seances_eleves','numero_de_la_seance_dans_le_mois','id','payments','ancien_payments','le_mois','nb_presences','numtel'));


        // code...
    }

    public function payer_prof1($id_groupe)
    {

        $id_groupe = ((int)$id_groupe);

        $le_mois = Groupe::get_the_month($id_groupe);

        $presences = DB::select("select FLOOR((s.num-1)/4)+1 as mois,s.num,count(se.presence) as presences from seances_eleves se , seances s where se.id_seance=s.id and s.id_groupe = $id_groupe and se.presence=1 group by FLOOR((s.num-1)/4)+1,s.num ");

        $groupe = DB::select("select * from groupes where id = $id_groupe ");

        $groupe = $groupe[0];

        $cycle = substr($groupe->niveau,2,2);

        $presences_mois = DB::select("select FLOOR((s.num-1)/4)+1 as mois,count(se.presence) as presences from seances_eleves se , seances s where se.id_seance=s.id and s.id_groupe = $id_groupe and se.presence=1 group by FLOOR((s.num-1)/4)+1");

        $numero_de_la_seance_dans_le_mois = (Groupe::current_seance($id_groupe));

        $les_payements = DB::select("select * from payement_profs where id_groupe = $id_groupe order by num_mois");

        $eleves_ne_payent_pas = (DB::select("select distinct e.nom,e.prenom from eleves e,seances_eleves se, seances s where (s.id=se.id_seance) and (s.id_groupe=$id_groupe) and (se.id_eleve=e.id) and (se.presence = 2) "));

        ini_set('display_errors', 1);
                
        return view('Home.payer_prof',compact('presences','groupe','le_mois','presences_mois','numero_de_la_seance_dans_le_mois','les_payements','eleves_ne_payent_pas','cycle')) ;
        
        //


        // code...
    }

    public function payer_prof(Request $request)
    {
        $data = ($request->all());
        $num_mois = $data['num_mois'];
        $num_seance = $data['num_seance'];
        $id_groupe = $data['id_groupe'];
        $nom_prenom_prof = $data['nom_prenom_prof'];
        $payement = $data['payement'];

        $nom_prenom = (explode('-',$nom_prenom_prof));
        
        $nom = $nom_prenom[0];
        $prenom = $nom_prenom[1];
        
        $id_prof = DB::select("select id from profs where (nom = \"$nom\" and prenom = \"$prenom\") or (nom = \"$prenom\" and prenom = \"$nom\") ");
        
        $id_prof = $id_prof[0]->id;

        DB::insert("insert into payement_profs(id_prof,id_groupe,num_mois,num_seance,payement) values(\"$id_prof\",\"$id_groupe\",\"$num_mois\",\"$num_seance\",\"$payement\")");

        $now = DB::select("select now() as now");

        $now = $now[0]->now;
        
        return response()->json($now);

        // code...
    }

    public function completer_frais($id_groupe,$id_eleve,Request $request)
    {

        $frais = ($request->frais);

        DB::update("update eleves e set e.frais = e.frais+$frais where id = '$id_eleve' ");

        return back();

        // code...
    }

    public function modifier_groupe(Request $request)
    {
        $pourcentage_ecole = 100-$request->pourcentage_prof;

        $id_groupe = $request->id_groupe;

        DB::update("update groupes set heure_debut = '$request->heure_debut',heure_fin = '$request->heure_fin',heure_fin = '$request->heure_fin',pourcentage_prof='$request->pourcentage_prof',pourcentage_ecole='$pourcentage_ecole',classe='$request->salle',prof='$request->prof',niveau='$request->niveau',matiere='$request->matiere',jour='$request->jour',tarif='$request->tarif' where id='$id_groupe' ");

       session()->flash('notification.message' , 'Groupe : '.$request->matiere.' , '.$request->niveau.' Prof : '.$request->prof.' Modifié avec succés');

       session()->flash('notification.type' , 'success'); 

       return back();

        // code...
    }



    public function fit_salles(Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');

        $annee_scolaire=(Groupe::get_annee_scolaire());

        $dispo=(DB::select("select * from groupes where jour = \"$request->jour\" and classe=\"$request->salle\" and visible = 1 and id <> '$request->id_groupe' and annee_scolaire = \"$annee_scolaire\""));

        $dispo1=(DB::select("select * from special_groupes where jour = \"$request->jour\" and salle=\"$request->salle\" and visible = 1 and id <> '$request->id_groupe' and annee_scolaire = \"$annee_scolaire\""));

        $dispo = array_merge($dispo, $dispo1);

        $debut = strtotime($request->debut);
        $fin = strtotime($request->fin);

        foreach ($dispo as $disp) 
        {

            $time_debut = strtotime($disp->heure_debut);
            $time_fin = strtotime($disp->heure_fin);


            if(($debut>=$time_debut && $fin<=$time_fin)||
            ($time_debut<=$debut && $time_fin>=$fin)||
            ($debut>=$time_debut && $debut<$time_fin && $fin>=$time_fin)||
            ($debut<=$time_debut && $fin<=$time_fin && $fin>$time_debut)) 

            {
             
                return response()->json($disp);

                // code...
            }

            // code...
        }
        
        return response()->json(true);
        // code...
    }


    public function supprimer_eleve(Request $request)
    {

        $id_groupe = ((int)$request->id_groupe);

        $id_eleve = ((int)$request->id_eleve);

        $id_seances = (DB::select("select * from seances where id_groupe = $id_groupe "));

        DB::delete("delete from payment_groupes_eleves where id_groupe=$id_groupe and id_eleve = $id_eleve ");

        /*foreach ($id_seances as $id_seance) 
        {
            $id_seance=(int)($id_seance->id);

            DB::delete("delete from seances_eleves where id_seance=$id_seance and id_eleve = $id_eleve ");

            // code...
        }*/

        // code...
    }

    public function modifier_eleve($id_groupe,$id_eleve,Request $request)
    {
        
        DB::update("update eleves set num_tel = $request->numtel where id = '$id_eleve' ");

        return back();

        // code...
    }

    public function scanner($matricule)
    {
        $eleve = DB::select("select * from matricules where matricule=$matricule");
        $id_eleve = $eleve[0]->id_eleve;
        $id_groupe = $eleve[0]->id_groupe;

        $eleve = Eleve::find($id_eleve);
        $groupe = Groupe::find($id_groupe);
        

        $id_dernier_seance_du_groupe = (DB::select("select max(id) as id_derniere_seance from seances where id_groupe = \"$id_groupe\" "));
        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
        }

        $seance = Seanceseleve::where('id_eleve',$id_eleve)->where('id_seance',$id_dernier_seance_du_groupe)->first();

        (DB::update("update seances_eleves set presence =1, created_at = now()  
        where id_eleve = $id_eleve and id_seance = $id_dernier_seance_du_groupe "));
        
        return view('home.profile',compact('eleve','groupe','matricule','seance'));

    }

    public function annuler($matricule,$seance)
    {
        $eleve = DB::select("select * from matricules where matricule=$matricule");
        $id_eleve = $eleve[0]->id_eleve;
        $id_groupe = $eleve[0]->id_groupe;
        $eleve = Eleve::find($id_eleve);
        $groupe = Groupe::find($id_groupe);


        $id_dernier_seance_du_groupe = (DB::select("select max(id) as id_derniere_seance from seances where id_groupe = \"$id_groupe\" "));
        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
        }
      
        (DB::update("update seances_eleves set presence =1, created_at = now()  
            where id = $seance"));
        $seance = Seanceseleve::where('id_eleve',$id_eleve)->where('id_seance',$id_dernier_seance_du_groupe)->first();


        return view('home.profile',compact('eleve','groupe','matricule','seance'));

    }


    public function cloturer($id_groupe)
    {
        $eleves = Groupe::getElelvesIds($id_groupe);

        $id_dernier_seance_du_groupe = (DB::select("select max(id) as id_derniere_seance from seances where id_groupe = $id_groupe "));

        $num_seance_groupe = DB::select("select max(num) as numero_de_la_derniere_seance_du_groupe from seances where id_groupe = $id_groupe ");

        $num_seance_groupe = $num_seance_groupe[0]->numero_de_la_derniere_seance_du_groupe;

        $seance_prochaine = $num_seance_groupe+1;

        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
        }
        DB::insert("insert into seances (id_groupe,num) values (\"$id_groupe\",\"$seance_prochaine\" ) ");        

        $num_seance_groupe = DB::select("select max(num) as numero_de_la_derniere_seance_du_groupe from seances where id_groupe = $id_groupe ");
        
        $num_seance_groupe = $num_seance_groupe[0]->numero_de_la_derniere_seance_du_groupe;

        $id_dernier_seance_du_groupe = (DB::select("select max(id) as id_derniere_seance from seances where id_groupe = $id_groupe "));

        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
        }
        foreach($eleves as $eleve)
        {

            $id_eleve = $eleve->id;

            (DB::insert("insert into seances_eleves(num_seance,paye,payement,id_seance,id_eleve) 
            values(\"$num_seance_groupe\",1,2000,\"$id_dernier_seance_du_groupe\",\"$id_eleve\") "));
    


        }


        // return view('profile');

        return back();

    }


}
