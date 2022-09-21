<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Eleve;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class GroupeController extends Controller
{

    public function inscription()
    {

        return view('Home.inscription');


        // code...
    }

    public function groupes()
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');

        $annee_scolaire=(Groupe::get_annee_scolaire());
        
        $groupes=Groupe::all_groupes();

        $last_id = Groupe::last_ids();

        $salles=DB::select("select * from classes where visible =1 order by num");

        $matieres=DB::select("select * from matieres /*where visible =1*/");

        $profs=DB::select("select * from profs where visible = 1");

        $niveaux=DB::select("select * from niveaux where visible = 1 order by cycle,niveau,filiere");
        
        $eleves_groupe = DB::select("select p.id_groupe,count(DISTINCT p.id_groupe,e.id,e.nom,e.prenom,e.num_tel) as nb_eleves from eleves e,payment_groupes_eleves p where (p.id_eleve=e.id ) group by p.id_groupe ");

        return view('Home.groupes',compact('groupes','last_id','salles','matieres','profs','niveaux','annee_scolaire','eleves_groupe'));


        # code...
    }

    public function fit_salles(Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');



        $annee_scolaire=(Groupe::get_annee_scolaire());

        $dispo=(DB::select("select * from groupes where jour = \"$request->jour\" and classe=\"$request->salle\" and visible = 1 and annee_scolaire = \"$annee_scolaire\""));

        $dispo1=(DB::select("select * from special_groupes where jour = \"$request->jour\" and salle=\"$request->salle\" and visible = 1 and annee_scolaire = \"$annee_scolaire\""));

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

    public function modifier(Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');



    	DB::update("update groupes set tel = \"$request->tel\" where id = \"$request->id\" ");

    	# code...
    }

    public function supprimer(Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');

    	DB::update("update groupes set visible = 0 where id = \"$request->id\" ");

    	# code...
    }

    public function ajouter(Request $request)
    {   
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');
        
        if($request->type_payement=="salaire")
        {

            $request->pourcentage_prof = $request->salaire_prof;

            //
        }

        $annee_scolaire=(Groupe::get_annee_scolaire());

        $prctg_ecole = 100-$request->pourcentage_prof;

        DB::insert("insert into groupes(jour,heure_debut,heure_fin,classe,matiere,niveau,prof,pourcentage_prof,pourcentage_ecole,tarif,annee_scolaire) values(\"$request->jour\",\"$request->heure_debut\",\"$request->heure_fin\",\"$request->salle\",\"$request->matiere\",\"$request->niveau\",\"$request->prof\",\"$request->pourcentage_prof\",\"$prctg_ecole\",\"$request->tarif\",\"$annee_scolaire\")");

        $last = DB::select("select * from groupes order by id desc");

        $id_last_groupe = $last[0]->id;

        DB::insert("insert into seances(id_groupe,num) values (\"$id_last_groupe\",1)");

       
       session()->flash('notification.message' , 'Groupe : '.$request->matiere.' , '.$request->niveau.' Prof : '.$request->prof.' ajoutée avec succés');

       session()->flash('notification.type' , 'success'); 

       return back();

    	# code...
    }

    public function get_profs(Request $request)
    {
            
        set_time_limit(0);

        ini_set('memory_limit', '-1');





        $profs1=DB::select("select * from profs where (matiere = \"$request->matiere\" and cycle=\"$request->cycle\") and visible = 1 ");

        $profs2=DB::select("select * from profs where (matiere <> \"$request->matiere\" or cycle <> \"$request->cycle\") and visible = 1 ");
        
        $tous=array_merge($profs1,$profs2);

        return response()->json($tous);
        // code...
    }

    public function afficher_groupe($id)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');

        $groupe = (DB::select("select * from groupes where id = \"$id\" "));

        $groupe = $groupe[0];

        $this_mois = (Groupe::get_the_month($groupe->id));
        
        $seances_eleves = DB::select("select e.id as id_eleve,s.id_groupe,s.num as numero_de_la_seance_dans_le_mois,se.presence,se.created_at from seances s , seances_eleves se , eleves e where (s.id_groupe = \"$id\") and (se.id_seance=s.id) and (se.id_eleve = e.id) /*and ((FLOOR((s.num-1)/4)+1)=\"$this_mois\" or (FLOOR((s.num-1)/4)+1)=\"$this_mois-1\" or (FLOOR((s.num-1)/4)+1)=\"$this_mois+1\" )*/ order by e.nom,e.prenom,s.num");
        
        $eleves_groupe = DB::select("select DISTINCT e.id,e.nom,e.prenom,e.num_tel from eleves e, payment_groupes_eleves p where (p.id_groupe = \"$id\" and p.id_eleve=e.id ) order by e.nom,e.prenom ");
        
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

        $nb_presences = (DB::select("select FLOOR((s.num-1)/4)+1 as num_mois,count(se.presence) as nb_presence from seances_eleves se, seances s where(se.id_seance=s.id) and (s.id_groupe=\"$id\") and (se.presence = 1) group by FLOOR((s.num-1)/4)+1  order by num_mois"));

        //dump($nb_presences);
        
        $nom_prenom = (explode('-',$groupe->prof));
        
        $nom = $nom_prenom[0];
        $prenom = $nom_prenom[1];
        
        $numtel = DB::select("select id,nom,prenom,tel from profs where (nom = \"$nom\" and prenom = \"$prenom\") or (nom = \"$prenom\" and prenom = \"$nom\") ");
        
        $numtel = $numtel[0];

        $id_prof = $numtel->id;

        $eleves_gratuits = (DB::select("select id_groupe,id_eleve,floor(avg(paye)) as il_paye from payment_groupes_eleves where id_groupe=\"$id\" group by id_groupe,id_eleve having floor(avg(paye))=0 "));
        
        $payements_prof = DB::select("select * from payement_profs where id_groupe = \"$id\" and id_prof=\"$id_prof\" order by num_mois");
        
        //dd($payements_prof);

        $salles=DB::select("select * from classes where visible =1 order by num");

        $matieres=DB::select("select * from matieres /*where visible =1*/");

        $profs=DB::select("select * from profs where visible = 1");

        $niveaux=DB::select("select * from niveaux where visible = 1 order by cycle,niveau,filiere");        
        
        return view('Home.single_groupe',compact('groupe','eleves_groupe','seances_eleves','numero_de_la_seance_dans_le_mois','id','payments','ancien_payments','le_mois','nb_presences','numtel','eleves_gratuits','payements_prof','salles','matieres','profs','niveaux'));

        // code...
    }

    public function ajouter_eleve($id,Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');

        ini_set('max_input_vars', '500000000');

        $id_groupe = $id;
        
        Eleve::add_eleve($id,$request->nom,$request->prenom,$request->num_tel,$request->payment,$request->cotisations,$request->frais,$request->matricule);
            
        $eleve = DB::select("select * from eleves order by id desc limit 1");
        
        $id_eleve = $eleve[0]->id;
        
        return Redirect::to('/home/imprimer_bon/'.$id_eleve.'/'.$id_groupe.'/'.$request->payment);

        return back();

        // code...
    }


    public function verif_existance(Request $request)
    {

        $data = ($request->all());

        $nom = $data['nom'];

        $prenom = $data['prenom'];

        $id_groupe = $data['id_groupe'];

        $leleve = DB::select("select id,num_tel,frais from eleves where (nom=\"$nom\" and prenom=\"$prenom\") or (prenom=\"$nom\" and nom=\"$prenom\")");

        if(count($leleve)>0)
        {

            $id_eleve = $leleve[0]->id;

            $existe = DB::select("select * from payment_groupes_eleves where id_groupe = \"$id_groupe\" and id_eleve=\"$id_eleve\" ");

            if(count($existe)>0)
            {

                return response()->json(false);

                //
            }

            return response()->json($leleve[0]);

            //
        }
        else
        {

            return response()->json(0);

            //
        }

        // code...
    }


    //
}
