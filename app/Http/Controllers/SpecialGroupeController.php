<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class SpecialGroupeController extends Controller
{
 
    public function index()
    {
        
        $annee_scolaire=(Groupe::get_annee_scolaire());
        
        $groupes=Groupe::all_groupes_speciaux();

        $last_id = Groupe::last_special_groupe_ids();

        $salles=DB::select("select * from classes where visible =1 order by num");

        $matieres=DB::select("select * from matieres order by nom /*where visible =1*/");

        $profs=DB::select("select * from profs where visible = 1");

        $niveaux=DB::select("select * from niveaux where visible = 1");
        
        $eleves_groupe = DB::select("select s.id_groupe_special,count(DISTINCT s.id_groupe_special,e.id,e.nom,e.prenom,e.num_tel) as nb_eleves from eleves e, seances_speciales_eleves se , seances_speciales s where (s.id = se.id_seance_speciale and se.id_eleve=e.id ) group by s.id_groupe_special ");
                
        return view('Home.groupes_special',compact('groupes','last_id','salles','matieres','profs','niveaux','annee_scolaire','eleves_groupe'));

        

        // code...
    }


    public function get_profs(Request $request)
    {
            
        $profs1=DB::select("select * from profs where (matiere = \"$request->matiere\") and visible = 1 ");

        $profs2=DB::select("select * from profs where (matiere <> \"$request->matiere\") and visible = 1 ");
        
        $tous=array_merge($profs1,$profs2);

        return response()->json($tous);

        // code...
    }

    public function get_matiere(Request $request)
    {

        $nom_prenom = (explode('-',$request->prof));
        
        $nom = $nom_prenom[0];
        $prenom = $nom_prenom[1];
            
        $matieres = DB::select("select matiere from profs where (nom = \"$nom\" and prenom = \"$prenom\") or (nom = \"$prenom\" and prenom = \"$nom\") ");

        return response()->json($matieres);

        // code...
    }


    public function ajouter(Request $request)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');

        $annee_scolaire=(Groupe::get_annee_scolaire());

        $prctg_ecole = 100-$request->pourcentage_prof;

        DB::insert("insert into special_groupes(jour,heure_debut,heure_fin,salle,niveau,pourcentage_prof,pourcentage_ecole,tarif,annee_scolaire) values(\"$request->jour\",\"$request->heure_debut\",\"$request->heure_fin\",\"$request->salle\",\"$request->niveau\",\"$request->pourcentage_prof\",\"$prctg_ecole\",\"$request->tarif\",\"$annee_scolaire\")");

        $last = DB::select("select * from special_groupes order by id desc");

        $id_last_groupe = $last[0]->id;

        DB::insert("insert into seances_speciales(id_groupe_special,num,id_prof) values (\"$id_last_groupe\",1,0)");
       
        session()->flash('notification.message' , 'Groupe Spécial : '.$id_last_groupe.' , '.$request->niveau.' ajoutée avec succés');

        session()->flash('notification.type' , 'success'); 

        return back();

        # code...

        // code...
    }

    public function afficher_groupe($id_groupe_special)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');

        $groupe = (DB::select("select * from special_groupes where id = \"$id_groupe_special\" "));

        $groupe = $groupe[0];

        $this_mois = (Groupe::get_the_month($groupe->id));
        
        $seances_eleves = DB::select("select e.id as id_eleve,s.id_groupe_special,s.num as numero_de_la_seance_dans_le_mois,se.presence,se.created_at from seances_speciales s , seances_speciales_eleves se , eleves e where (s.id_groupe_special = \"$id_groupe_special\") and (se.id_seance_speciale=s.id) and (se.id_eleve = e.id) /*and ((FLOOR((s.num-1)/4)+1)=\"$this_mois\" or (FLOOR((s.num-1)/4)+1)=\"$this_mois-1\" or (FLOOR((s.num-1)/4)+1)=\"$this_mois+1\" )*/ order by e.nom,e.prenom,s.num");
        
        $eleves_groupe = DB::select("select DISTINCT e.id,e.nom,e.prenom,e.num_tel from eleves e, seances_speciales_eleves se , seances_speciales s where ( s.id_groupe_special = \"$id_groupe_special\" and s.id = se.id_seance_speciale and se.id_eleve=e.id ) order by e.nom,e.prenom ");

        $nbr_seance_mois = (DB::select("select num as numero_de_la_seance_dans_le_mois from seances_speciales where id_groupe_special = \"$id_groupe_special\" order by num desc "));
        
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

        $le_mois = (Groupe::get_the_month_special($id_groupe_special));

        $payments = DB::select("select id_eleve,id_groupe_special,num_mois,sum(payement) as payment_du_mois from payement_groupe_special_eleve where id_groupe_special =\"$id_groupe_special\" and num_mois = \"$le_mois\" group by id_eleve,id_groupe_special,num_mois order by id_eleve,num_mois"); 

        $ancien_payments = DB::select("select pg.id_eleve,pg.id_groupe_special,pg.num_mois,sum(payement) as payment_du_mois,sum(exoneree) as exoneree from payement_groupe_special_eleve pg where id_groupe_special =\"$id_groupe_special\" and num_mois <> \"$le_mois\" group by pg.id_eleve,pg.id_groupe_special,pg.num_mois having (sum(payement) <> (select tarif from special_groupes where id = \"$id_groupe_special\") ) order by id_eleve,num_mois"); 


        $nb_presences = (DB::select("select FLOOR((s.num-1)/4)+1 as num_mois,count(se.presence) as nb_presence from seances_speciales_eleves se, seances_speciales s where(se.id_seance_speciale=s.id) and (s.id_groupe_special=\"$id_groupe_special\") and (se.presence = 1) group by FLOOR((s.num-1)/4)+1  order by num_mois"));
        
        $eleves_gratuits = (DB::select("select id_groupe_special,id_eleve,floor(avg(paye)) as il_paye from payement_groupe_special_eleve where id_groupe_special=\"$id_groupe_special\" group by id_groupe_special,id_eleve having floor(avg(paye))=0 "));

        //$payements_prof = DB::select("select * from payement_profs where id_groupe = \"$id_groupe_special\" and id_prof=\"$id_prof\" order by num_mois");
        
        //dd($payements_prof);

        $profs = DB::select("select * from profs where visible = 1 order by nom,cycle,matiere");

        $matieres = DB::select("select * from matieres order by nom");
        
        return view('Home.single_groupe_special',compact('groupe','eleves_groupe','seances_eleves','numero_de_la_seance_dans_le_mois','id_groupe_special','payments','ancien_payments','le_mois','nb_presences','eleves_gratuits','profs','matieres'));


        //
    } 


    public function ajouter_eleve($id,Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');

        ini_set('max_input_vars', '500000000');
        
        Eleve::add_eleve_special($id,$request->nom,$request->prenom,$request->num_tel,$request->payment,$request->cotisations);

        return back();

        // code...
    }


    public function valider_coches(Request $request)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');

        ini_set('max_input_vars','5500');

        $data = $request->all();
        
        $la_matiere = $data["la_matiere"];
        $le_prof = $data["le_prof"];
        
        $eleves_groupe = $data["eleves_groupe"];
        $groupe = $data["groupe"];
        $numero_de_la_seance_dans_le_mois = $data["numero_de_la_seance_dans_le_mois"];
        $les_coches = $data["les_coches"];

        if(count($data)>7)
        {
            $eleves_gratuits = $data["eleves_gratuits"];
            //
        }
        else
        {

            $eleves_gratuits=[];

            //
        }
        
        $id_groupe = $groupe;

        $le_mois = Groupe::get_the_month_special($id_groupe);
        
        if(!empty($data["les_input_payement"]))
        {
            $les_input_payement = $data["les_input_payement"];
        }
        
        $id_dernier_seance_du_groupe = (DB::select("select max(id) as id_derniere_seance from seances_speciales where id_groupe_special = \"$id_groupe\" "));
        
        $num_seance_groupe = DB::select("select max(num) as numero_de_la_derniere_seance_du_groupe from seances_speciales where id_groupe_special = \"$id_groupe\" ");

        $num_seance_groupe = $num_seance_groupe[0]->numero_de_la_derniere_seance_du_groupe;

        $seance_prochaine = $num_seance_groupe+1;

        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
            //
        }

        DB::update("update seances_speciales set id_prof='$le_prof',matiere='$la_matiere' where id_groupe_special = '$id_groupe' and num='$num_seance_groupe'");

        DB::insert("insert into seances_speciales (id_groupe_special,num,id_prof,matiere) values (\"$id_groupe\",\"$seance_prochaine\",'$le_prof','$la_matiere') ");        
        
        $last = DB::select("select max(id) as last_id from seances_speciales where id_groupe_special = \"$id_groupe\" ");
        
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
                        
                        (DB::update("update seances_speciales_eleves set  presence=2,created_at = \"$now\"  where id_eleve = \"$id_eleve\" and id_seance_speciale = \"$id_dernier_seance_du_groupe\" "));

                        //
                    }
                    elseif($presence == 0)
                    {

                        (DB::update("update seances_speciales_eleves set presence=0,created_at = \"$now\"  where id_eleve = \"$id_eleve\" and id_seance_speciale = \"$id_dernier_seance_du_groupe\" "));

                        //
                    }


                    $esq_gratuit++;

                    // code...
                }

                //
            }

            if ($esq_gratuit==0) 
            {
                
                (DB::update("update seances_speciales_eleves set presence = \"$presence\",created_at = \"$now\"  where id_eleve = \"$id_eleve\" and id_seance_speciale = \"$id_dernier_seance_du_groupe\" "));
                
                // code...
            }


            (DB::insert("insert into seances_speciales_eleves(id_seance_speciale,id_eleve,presence) values(\"$last_id_seance\",\"$id_eleve\",0) "));
    
            if(!empty($data["les_input_payement"]))
            {

                (DB::insert("insert into payement_groupe_special_eleve(id_groupe_special,id_eleve,num_seance,payement,num_mois) values(\"$id_groupe\",\"$id_eleve\",\"$num_seance_groupe\",\"$payement\",\"$le_mois\") "));
            }

            // code...
        }

        
        // code...
    }



    public function historique_payement($id_groupe,$id_eleve)
    {

        set_time_limit(0);

        ini_set('memory_limit', '-1');


        $groupe = DB::select("select * from special_groupes where id = \"$id_groupe\" ");
        $groupe = $groupe[0];
        
        $eleve = DB::select("select * from eleves where id = \"$id_eleve\" ");
        $eleve = $eleve[0];
        
        $le_mois = Groupe::get_the_month_special($id_groupe);

        $payement_eleve = DB::select("select * from payement_groupe_special_eleve where id_eleve = \"$id_eleve\" and id_groupe_special=\"$id_groupe\" and payement <> 0 order by num_mois,created_at ");
        
        $seances_eleves = DB::select("select s.id_prof,s.matiere, se.id_eleve,se.presence,s.num,se.created_at from seances_speciales_eleves se, seances_speciales s where (se.id_seance_speciale=s.id) and (s.id_groupe_special = \"$id_groupe\") and (id_eleve = \"$id_eleve\") order by s.num ");

        $les_presences = DB::select("select se.id_eleve,FLOOR((s.num-1)/4)+1 as mois,count(presence) as presences from seances_speciales_eleves se,seances_speciales s where (se.id_seance_speciale = s.id) and (se.id_eleve = \"$id_eleve\") and (s.id_groupe_special = \"$id_groupe\") and (se.presence = 1) group by se.id_eleve,s.num");

        $les_absences = DB::select("select se.id_eleve,FLOOR((s.num-1)/4)+1 as mois,count(presence) as presences from seances_speciales_eleves se,seances_speciales s where (se.id_seance_speciale = s.id) and (se.id_eleve = \"$id_eleve\") and (s.id_groupe_special = \"$id_groupe\") and (se.presence = 0) group by se.id_eleve,s.num");

        $retards = DB::select("select pg.id_eleve,pg.id_groupe_special,pg.num_mois,sum(payement) as payment_du_mois,sum(exoneree) as exoneree from payement_groupe_special_eleve pg where id_groupe_special =\"$id_groupe\"  and pg.id_eleve=\"$id_eleve\" group by pg.id_eleve,pg.id_groupe_special,pg.num_mois order by id_eleve,num_mois"); 

        $current = (Groupe::current_seance_special($groupe->id));

        $num_seance_groupe = DB::select("select max(num) as numero_de_la_derniere_seance_du_groupe from seances where id_groupe = \"$id_groupe\" ");

        $num_seance_groupe = $num_seance_groupe[0]->numero_de_la_derniere_seance_du_groupe;

        $presences = DB::select("select s.id_prof,FLOOR((s.num-1)/4)+1 as mois,s.num,count(se.presence) as presences from seances_speciales_eleves se , seances_speciales s where se.id_seance_speciale=s.id and s.id_groupe_special = $id_groupe and se.presence=1 group by s.id_prof, FLOOR((s.num-1)/4)+1,s.num ");        
        
        return view('Home.single_eleve_special',compact('groupe','eleve','payement_eleve','seances_eleves','le_mois','les_presences','les_absences','retards','current','num_seance_groupe','presences'));

        // code...
    }

    public function verif_existance(Request $request)
    {

        $data = ($request->all());

        $nom = $data['nom'];

        $prenom = $data['prenom'];

        $id_groupe = $data['id_groupe'];

        $leleve = DB::select("select id,num_tel from eleves where (nom=\"$nom\" and prenom=\"$prenom\") or (prenom=\"$nom\" and nom=\"$prenom\")");

        if(count($leleve)>0)
        {

            $id_eleve = $leleve[0]->id;

            $existe = DB::select("select * from payement_groupe_special_eleve where id_groupe_special = \"$id_groupe\" and id_eleve=\"$id_eleve\" ");

            if(count($existe)>0)
            {

                return response()->json(false);

                //
            }

            return response()->json($leleve[0]->num_tel);

            //
        }
        else
        {

            return response()->json(0);

            //
        }

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

        dump(DB::update("update payement_groupe_special_eleve set exoneree = 1 where (id_groupe_special = \"$id_groupe\") and (id_eleve = \"$id_eleve\") and (num_mois=\"$num_mois\")"));

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
        
        dump(DB::insert("insert into payement_groupe_special_eleve(id_groupe_special,id_eleve,num_seance,payement,num_mois) values(\"$id_groupe\",\"$id_eleve\",\"$current_seance\",\"$payement\",\"$num_mois\") "));
        
        //
    }

    public function supprimer(Request $request)
    {
        
        set_time_limit(0);

        ini_set('memory_limit', '-1');

        DB::update("update special_groupes set visible = 0 where id = \"$request->id\" ");

        # code...
    }


    public function payement_prof($id_groupe)
    {  

        $presences = DB::select("select s.id_prof,FLOOR((s.num-1)/4)+1 as mois,s.num,count(se.presence) as presences from seances_speciales_eleves se , seances_speciales s where se.id_seance_speciale=s.id and s.id_groupe_special = $id_groupe and se.presence=1 group by s.id_prof, FLOOR((s.num-1)/4)+1,s.num ");
        
        $presences_mois = DB::select("select FLOOR((s.num-1)/4)+1 as mois,count(se.presence) as presences from seances_speciales_eleves se , seances_speciales s where se.id_seance_speciale=s.id and s.id_groupe_special = $id_groupe and se.presence=1 group by FLOOR((s.num-1)/4)+1");           

        $groupe = (DB::select("select * from special_groupes where id = \"$id_groupe\" "));
        $groupe = $groupe[0];

        $eleves_ne_payent_pas = (DB::select("select distinct e.nom,e.prenom from eleves e,seances_speciales_eleves se, seances_speciales s where (s.id=se.id_seance_speciale) and (s.id_groupe_special=$id_groupe) and (se.id_eleve=e.id) and (se.presence = 2) "));        
        
        $le_mois = Groupe::get_the_month_special($id_groupe);

        return view('Home.payer_prof_special',compact('presences','groupe','eleves_ne_payent_pas','le_mois','presences_mois')) ;        
        
        // code...
    }     

    //
}
