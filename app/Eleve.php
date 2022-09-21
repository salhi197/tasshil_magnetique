<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class Eleve extends Model
{

    public static function get_allgroupes_of_one_eleve($id_eleve,$id_groupe)
    {

        $id_groupes = DB::select("select distinct g.id from groupes g, seances s, seances_eleves se 
            where (g.id=s.id_groupe and s.id = se.id_seance and se.id_eleve = $id_eleve and g.id<>$id_groupe) ");

        return $id_groupes;

        //
    }

    public static function add_eleve($id_groupe,$nom,$prenom,$num_tel,$payement,$cotisations,$frais,$matricule)
    {

        $il_paye = ($cotisations);

        $le_mois = (Groupe::get_the_month($id_groupe));

        $dernier_seance_du_groupe = (DB::select("select num as derniere_seance from seances where id_groupe = \"$id_groupe\" order by num desc "));
        
        if(count($dernier_seance_du_groupe)>0)
        {
            $dernier_seance_du_groupe = $dernier_seance_du_groupe[0]->derniere_seance+1;
            //
        }
        else
        {
            $dernier_seance_du_groupe = 1;
        }

        $id_dernier_seance_du_groupe = (DB::select("select id as id_derniere_seance from seances where id_groupe = \"$id_groupe\" order by id desc "));
        
        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
            //
        }
        else
        {
            dd("makach seance");
        }

        $last = (DB::select("select * from eleves where (nom=\"$nom\" and prenom=\"$prenom\")or(nom=\"$prenom\" and nom=\"$prenom\") "));

        if (count($last)>0) 
        {
            
            $id_eleve = $last[0]->id;

            DB::update("update eleves set frais = frais+'$frais' where id = '$id_eleve'");

            // code...
        }
        else
        {
    
            DB::insert("insert into eleves(nom,prenom,num_tel,frais) values(\"$nom\",\"$prenom\",\"$num_tel\",'$frais') ");

            $last = DB::select("select * from eleves order by id desc");

            $id_eleve = $last[0]->id;
            DB::insert("insert into matricules(id_eleve,id_groupe,matricule) values($id_eleve,$id_groupe,$matricule) ");

        }
        
        if ($il_paye == 1) 
        {

            DB::insert("insert into payment_groupes_eleves (id_groupe,id_eleve,num_seance,payement,num_mois) values (\"$id_groupe\",\"$id_eleve\",\"$dernier_seance_du_groupe\",\"$payement\",\"$le_mois\")");
        
            //
        }
        else
        {

            DB::insert("insert into payment_groupes_eleves (id_groupe,id_eleve,num_seance,payement,num_mois,paye) values (\"$id_groupe\",\"$id_eleve\",\"$dernier_seance_du_groupe\",\"$payement\",\"$le_mois\",0)");
            //
        }

        DB::insert("insert into seances_eleves (num_seance,paye,payement,presence,id_seance,id_eleve) values (\"$dernier_seance_du_groupe\",1,\"$payement\",0,\"$id_dernier_seance_du_groupe\",\"$id_eleve\") ");

        

        session()->flash('notification.message' , 'Elève : '.$last[0]->nom.' , '.$last[0]->prenom.' ajoutée avec succés');

        session()->flash('notification.type' , 'success');

        //
    }

    //use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'num_tel'        
    ];

    public function isInDawra($dawra)
    {
        return Dawraeleve::where(['id_dawra'=>$dawra,'id_eleve'=>$this->id])->first() === null;
    }


    public function getEleveDawraPayment($dawra)
    {
        $payment = Dawraeleve::where(['id_dawra'=>$dawra,'id_eleve'=>$this->id])->first()['payment'];
        return $payment;
    }

    public function getEleveDawraReste($dawra)
    {
        $reste = Dawraeleve::where(['id_dawra'=>$dawra,'id_eleve'=>$this->id])->first()['reste'];
        return $reste;
    }


    public function getDawraSeances($dawra)
    {
        $seances = Seancesdawra::where(['id_dawra'=>$dawra,'id_eleve'=>$this->id])->get();
        return $seances;
    }


    


    public static function add_eleve_special($id_groupe,$nom,$prenom,$num_tel,$payement,$cotisations)
    {


        $il_paye = ($cotisations);

        $le_mois = (Groupe::get_the_month_special($id_groupe));

        $dernier_seance_du_groupe = (DB::select("select num as derniere_seance from seances_speciales where id_groupe_special = \"$id_groupe\" order by num desc "));
        
        if(count($dernier_seance_du_groupe)>0)
        {
            $dernier_seance_du_groupe = $dernier_seance_du_groupe[0]->derniere_seance;
            //
        }
        else
        {
            $dernier_seance_du_groupe = 0;
        }

        $id_dernier_seance_du_groupe = (DB::select("select id as id_derniere_seance from seances_speciales where id_groupe_special = \"$id_groupe\" order by id desc "));
        
        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
            //
        }
        else
        {
            dd("makach seance");
        }

        $last = (DB::select("select * from eleves where (nom=\"$nom\" and prenom=\"$prenom\")or(nom=\"$prenom\" and nom=\"$prenom\") "));

        
        if (count($last)>0) 
        {
            
            $id_eleve = $last[0]->id;         

            // code...
        }
        else
        {
    
            DB::insert("insert into eleves(nom,prenom,num_tel,frais) values(\"$nom\",\"$prenom\",\"$num_tel\",\"$frais\") ");

            $last = DB::select("select * from eleves order by id desc");

            $id_eleve = $last[0]->id;

        }
        
        if ($il_paye == 1) 
        {

            DB::insert("insert into payement_groupe_special_eleve (id_groupe_special,id_eleve,num_seance,payement,num_mois) values (\"$id_groupe\",\"$id_eleve\",\"$dernier_seance_du_groupe\",\"$payement\",\"$le_mois\")");
        
            //
        }
        else
        {

            DB::insert("insert into payement_groupe_special_eleve (id_groupe_special,id_eleve,num_seance,payement,num_mois,paye) values (\"$id_groupe\",\"$id_eleve\",\"$dernier_seance_du_groupe\",\"$payement\",\"$le_mois\",0)");
            //
        }

        DB::insert("insert into seances_speciales_eleves (presence,id_seance_speciale,id_eleve) values (0,\"$id_dernier_seance_du_groupe\",\"$id_eleve\") ");

        

        session()->flash('notification.message' , 'Elève : '.$last[0]->nom.' , '.$last[0]->prenom.' ajoutée avec succés');

        session()->flash('notification.type' , 'success');

        //
    }

    public static function calculePresncesMois($id_eleve,$id_groupe)
    {
        $mois = Groupe::get_the_month($id_groupe);
        $min = $mois*4-3;
        $max = $mois*4;
        $presences = (DB::select("select presence 
        from seances_eleves se , seances s 
        where se.id_seance=s.id and s.id_groupe=$id_groupe and se.id_eleve=$id_eleve and (num_seance between $min and $max) and se.presence=1"));
        return count($presences);


    }
}
