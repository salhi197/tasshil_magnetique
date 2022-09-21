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


class ClasseController extends Controller
{

    public function classes()
    {
        
        $classes=Classe::all_classes();

        $last_id = Classe::last_ids();

        return view('Home.classes',compact('classes','last_id'));


        # code...
    }

    public function modifier(Request $request)
    {

    	DB::update("update classes set num = \"$request->nom\",nb_places_min = \"$request->min\",nb_places_max = \"$request->max\" where id = \"$request->id\" ");

    	# code...
    }

    public function supprimer(Request $request)
    {

    	DB::update("update classes set visible = 0 where id = \"$request->id\" ");

    	# code...
    }

    public function ajouter(Request $request)
    {

    	$min = ($request->min);
    	$max = ($request->max);
    	$nom = ($request->nom);

    	DB::insert("insert into classes(num,nb_places_min,nb_places_max) values(\"$nom\",\"$min\",\"$max\")");

    	# code...
    }

    //
}
