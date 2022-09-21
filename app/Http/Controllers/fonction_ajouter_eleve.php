        $il_paye = ($request->cotisations);

        $le_mois = (Groupe::get_the_month($id));

        $dernier_seance_du_groupe = (DB::select("select num as derniere_seance from seances where id_groupe = \"$id\" order by num desc "));
        
        if(count($dernier_seance_du_groupe)>0)
        {
            $dernier_seance_du_groupe = $dernier_seance_du_groupe[0]->derniere_seance;
            //
        }
        else
        {
            $dernier_seance_du_groupe = 0;
        }

        $id_dernier_seance_du_groupe = (DB::select("select id as id_derniere_seance from seances where id_groupe = \"$id\" order by id desc "));
        
        if(count($id_dernier_seance_du_groupe)>0)
        {
            $id_dernier_seance_du_groupe = $id_dernier_seance_du_groupe[0]->id_derniere_seance;
            //
        }
        else
        {
            dd("makach seance");
        }

        $last = (DB::select("select * from eleves where (nom=\"$request->nom\" and prenom=\"$request->prenom\")or(nom=\"$request->prenom\" and nom=\"$request->prenom\") "));

        if (count($last)>0) 
        {
            
            $id_eleve = $last[0]->id;         

            // code...
        }
        else
        {
    
            DB::insert("insert into eleves(nom,prenom,num_tel) values(\"$request->nom\",\"$request->prenom\",\"$request->num_tel\") ");

            $last = DB::select("select * from eleves order by id desc");

            $id_eleve = $last[0]->id;

        }
        
        if ($il_paye == 1) 
        {

            DB::insert("insert into payment_groupes_eleves (id_groupe,id_eleve,num_seance,payement,num_mois) values (\"$id\",\"$id_eleve\",\"$dernier_seance_du_groupe\",\"$request->payment\",\"$le_mois\")");
        
            //
        }
        else
        {

            DB::insert("insert into payment_groupes_eleves (id_groupe,id_eleve,num_seance,payement,num_mois,paye) values (\"$id\",\"$id_eleve\",\"$dernier_seance_du_groupe\",\"$request->payment\",\"$le_mois\",0)");
            //
        }

        DB::insert("insert into seances_eleves (num_seance,paye,payement,presence,id_seance,id_eleve) values (\"$dernier_seance_du_groupe\",1,\"$request->payment\",0,\"$id_dernier_seance_du_groupe\",\"$id_eleve\") ");

        
        session()->flash('notification.message' , 'Elève : '.$last[0]->nom.' , '.$last[0]->prenom.' ajoutée avec succés');

        session()->flash('notification.type' , 'success'); 
