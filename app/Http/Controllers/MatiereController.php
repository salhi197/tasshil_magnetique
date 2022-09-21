<?php

namespace App\Http\Controllers;

use App\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class MatiereController extends Controller
{

    public function matieres()
    {
        
        $matieres=Matiere::all_matieres();

        $last_id = Matiere::last_ids();

        return view('Home.matieres',compact('matieres','last_id'));


        # code...
    }

    public function modifier(Request $request)
    {

    	DB::update("update matieres set tel = \"$request->tel\" where id = \"$request->id\" ");

    	# code...
    }

    public function supprimer(Request $request)
    {

    	DB::update("update matieres set visible = 0 where id = \"$request->id\" ");

    	# code...
    }

    public function ajouter(Request $request)
    {   
        
    	$nom = ($request->nom);

    	DB::insert("insert into matieres(nom) values(\"$nom\")");

    	# code...
    }

    //



    //
}
