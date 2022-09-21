<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Eleve;
use App\Dawra;
use App\Dawraeleve;
use App\Dawrapayment;
use App\Seancesdawra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DawraController extends Controller
{

    public function dawrat()
    {

        $annee_scolaire=(Groupe::get_annee_scolaire());
        $dawrates=Dawra::all();
        $annee_scolaire=(Groupe::get_annee_scolaire());
        $salles=DB::select("select * from classes where visible =1 order by num");
        $niveaux=DB::select("select * from niveaux where visible = 1");
        $matieres=DB::select("select * from matieres /*where visible =1*/");
        $profs=DB::select("select * from profs where visible = 1");


        return view('Home.dawrates',compact('dawrates',
            'annee_scolaire',
            'salles',
            'niveaux',
            'matieres',
            'profs'
        ));

        # code...
    }

    public function fit_salles(Request $request)
    {

        $annee_scolaire=(Groupe::get_annee_scolaire());

        $dispo=(DB::select("select * from groupes where jour = \"$request->jour\" and classe=\"$request->salle\" and visible = 1 and annee_scolaire = \"$annee_scolaire\""));

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

    	DB::update("update groupes set tel = \"$request->tel\" where id = \"$request->id\" ");

    	# code...
    }

    public function supprimer(Request $request)
    {

    	DB::update("update groupes set visible = 0 where id = \"$request->id\" ");

    	# code...
    }

    public function ajouter(Request $request)
    {   
        $dawra = new Dawra();
        $dawra->prof = $request['prof'];
        $dawra->niveau = $request['niveau'];
        $dawra->matiere = $request['matiere'];
        $dawra->nbrseances = $request['nbrseances'];
        $dawra->pourcentage_prof = $request['pourcentage_prof'];
        $dawra->pourcentage_ecole = $request['pourcentage_ecole'];
        $dawra->tarif = $request['tarif'];
        $dawra->current_seance = 1;
        $dawra->save();
        session()->flash('notification.message' , 'Dawra : '.$request->matiere.' , '.$request->niveau.' Prof : '.$request->prof.' ajoutée avec succés');

        session()->flash('notification.type' , 'success'); 

           return back();

    	# code...
    }

    public function get_profs(Request $request)
    {
      
        $profs1=DB::select("select * from profs where (matiere = \"$request->matiere\" and cycle=\"$request->cycle\") and visible = 1 ");

        $profs2=DB::select("select * from profs where (matiere <> \"$request->matiere\" or cycle <> \"$request->cycle\") and visible = 1 ");
        
        $tous=array_merge($profs1,$profs2);

        return response()->json($tous);
    }

    public function afficher_dawra($id)
    {
        $dawra = Dawra::find($id);
        $eleves = Dawraeleve::where('id_dawra',$id)->pluck("id_eleve")->toArray();
        $eleves = Eleve::whereIn('id',$eleves)->get();
        $seances = Seancesdawra::where(['id_dawra'=>$id,'presence'=>1])->get()->count();
        $payment = ($seances*$dawra->tarif/$dawra->nbrseances) * $dawra->pourcentage_prof/100;
        return view('Home.single_dawra',compact('dawra','eleves','payment'));
        //,'eleves_groupe','seances_eleves','numero_de_la_seance_dans_le_mois','id','payments','ancien_payments','le_mois','nb_presences','numtel'));
        // code...
    }

    public function ajouter_eleve($id,Request $request)
    {
        $eleve = Eleve::where(
            [
                'nom'=>$request['nom'],
                'prenom'=>$request['prenom'],
                'num_tel'=>$request['num_tel'],                                
            ]
        )->first();
        if($eleve){
            // eleve qui existe
            $eleveInDawra = $eleve->isInDawra($id);
            if($eleveInDawra == false){
                // eleve deja assigné au dawra
                session()->flash('notification.message' , 'Elève :  Déja Ajouté ');
                session()->flash('notification.type' , 'success'); 
                return back();
        
            }else{
                //eleve qui existe mais il n'a pas été assigné , donc faudrai l'assigner
                $dawra = Dawra::find($id);
                $tarif= $dawra->tarif;


                $dawrapayment = new  Dawrapayment();
                $dawrapayment->id_eleve = $eleve->id;
                $dawrapayment->id_dawra = $dawra->id;
                $dawrapayment->montant = $request['payment'];
                $dawrapayment->save();    
    

                $nbrseances = $dawra->nbrseances;
                $dawraeleve = new Dawraeleve();
                $dawraeleve->id_eleve = $eleve->id;
                $dawraeleve->id_dawra = $dawra->id;
                $dawraeleve->payment = $request['payment'];
                if($tarif==$request['payment']){
                    $dawraeleve->paye = 1;
                }else{
                    $dawraeleve->paye = 0;
                }
                $dawraeleve->reste = $tarif-$request['payment'];            
                $dawraeleve->save();
    
                for($i=0;$i<$nbrseances;$i++) {
                    $seanceDawra = new Seancesdawra();
                    $seanceDawra->id_eleve = $eleve->id;
                    $seanceDawra->id_dawra = $dawra->id;
                    $seanceDawra->num_seance = $i+1;
                    $seanceDawra->presence = 0;
                    $seanceDawra->save();
                }
                session()->flash('notification.message' , 'Elève :  ajoutée avec succés');
                session()->flash('notification.type' , 'success'); 
                return back();
    
            }
        }else{
            //elve qui n'existe pas
            DB::insert("insert into eleves(nom,prenom,num_tel) values(\"$request->nom\",\"$request->prenom\",\"$request->num_tel\") ");
            $last = DB::select("select * from eleves order by id desc");
            $id_eleve = $last[0]->id;    
            $dawra = Dawra::find($id);
            $tarif= $dawra->tarif;
            $nbrseances = $dawra->nbrseances;
            $dawraeleve = new Dawraeleve();
            $dawraeleve->id_eleve = $id_eleve;
            $dawraeleve->id_dawra = $dawra->id;
            $dawraeleve->payment = $request['payment'];
            if($tarif==$request['payment']){
                $dawraeleve->paye = 1;
            }else{
                $dawraeleve->paye = 0;
            }

            $dawraeleve->reste = $tarif-$request['payment'];            
            $dawraeleve->save();
            for($i=0;$i<$nbrseances;$i++) {
                $seanceDawra = new Seancesdawra();
                $seanceDawra->id_eleve = $id_eleve;
                $seanceDawra->id_dawra = $dawra->id;
                $seanceDawra->num_seance = $i+1;
                $seanceDawra->presence = 0;
                $seanceDawra->save();
            }

            $dawrapayment = new  Dawrapayment();
            $dawrapayment->id_eleve = $id_eleve;
            $dawrapayment->id_dawra = $dawra->id;
            $dawrapayment->montant = $request['payment'];
            $dawrapayment->save();    

            session()->flash('notification.message' , 'Elève : '.$last[0]->nom.' , '.$last[0]->prenom.' ajoutée avec succés');
            session()->flash('notification.type' , 'success'); 
            return back();
        }
    }

    public function valider_coches(Request $request)
    {
        $data = json_decode($request['data']);
        $payments = json_decode($request['payments']);
        $dawra = $request['dawra'];
        foreach($payments as $payment){
            $dawra_eleves =Dawraeleve::where(['id_eleve'=>$payment->eleve,'id_dawra'=>$dawra])->first();
            $newReste = $dawra_eleves->reste - $payment->montant;
            $newPayment = $dawra_eleves->payment + $payment->montant;
            if(is_null($payment->montant)==false AND $payment->montant>0){
                $dawrapayment = new  Dawrapayment();
                $dawrapayment->id_eleve = $payment->eleve;
                $dawrapayment->id_dawra = $dawra;
                $dawrapayment->montant = $payment->montant ;
                $dawrapayment->save();    
            }
            DB::table('dawraeleves')
                        ->where(['id_eleve'=>$payment->eleve,'id_dawra'=>$dawra])
                        ->update([
                            'payment' => $newPayment,
                            'reste'=>$newReste
                        ]);
    
                        
        }
        
        foreach($data as $d){
            $eleve = Eleve::find($d->eleve);

            DB::table('seancesdawras')
                        ->where(['id_eleve'=>$d->eleve,'num_seance'=>$d->num_seance,'id_dawra'=>$dawra])
                        ->update(['presence' => 1]);
            /**
             * updae current seance
             */
        }


        if(count($data)>0){
            DB::table('dawras')
                        ->where(['id'=>$dawra])
                        ->increment('current_seance',1);

        }
    }


    public function verif_existance(Request $request)
    {
        $data = ($request->all());

        $nom = $data['nom'];

        $prenom = $data['prenom'];

        $id_dawra = $data['id_dawra'];

        $leleve = DB::select("select id,num_tel from eleves where (nom=\"$nom\" and prenom=\"$prenom\") or (prenom=\"$nom\" and nom=\"$prenom\")");

        if(count($leleve)>0)
        {

            $id_eleve = $leleve[0]->id;

            $existe = DB::select("select * from dawraeleves where id_dawra = \"$id_dawra\" and id_eleve=\"$id_eleve\" ");

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
        }
    }

    public function historique_payement($id_dawra,$id_eleve)
    {
        $dawarapayments = Dawrapayment::where(['id_eleve'=>$id_eleve,'id_dawra'=>$id_dawra])->get();
        $eleve = Eleve::find($id_eleve);
        $dawra = Dawra::find($id_dawra);

        return view('Home.payment_dawra',compact(
            'eleve',
            'dawra',
            'dawarapayments'
        ));
    }


    //
}
