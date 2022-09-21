<?php

namespace App\Http\Controllers;


use App\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class NiveauController extends Controller
{

    public function niveaux()
    {
        
        $niveaux=Niveau::all_niveaux();

        $last_id = Niveau::last_ids();

        return view('Home.niveaux',compact('niveaux','last_id'));


        # code...
    }

    public function modifier(Request $request)
    {

        DB::update("update niveaux set num = \"$request->nom\",nb_places_min = \"$request->min\",nb_places_max = \"$request->max\" where id = \"$request->id\" ");

        # code...
    }

    public function supprimer(Request $request)
    {

        DB::update("update niveaux set visible = 0 where id = \"$request->id\" ");

        # code...
    }

    public function ajouter(Request $request)
    {

        $niveauduniveau = ($request->niveauduniveau);
        $cycleduniveau = ($request->cycleduniveau);
        $filiereduniveau = ($request->filiereduniveau);

        if($cycleduniveau=="AS"||$cycleduniveau=="Univ") 
        {
            DB::insert("insert into niveaux(niveau,cycle,filiere) values(\"$niveauduniveau\",\"$cycleduniveau\",\"$filiereduniveau\")");
        }
        else
        {
            DB::insert("insert into niveaux(niveau,cycle,filiere) values(\"$niveauduniveau\",\"$cycleduniveau\",\"------\")");

        }


        # code...
    }

    //


    //
}
