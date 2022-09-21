<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Inscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::all();
        $niveaux=DB::select("select * from niveaux where visible = 1");
        $matieres=DB::select("select * from matieres /*where visible =1*/");

        return view('Home.inscriptions',compact('inscriptions','niveaux','matieres'));
    }
    
    /**
     * Ajouter Dawra
     */

    public function ajouter(Request $request)
    {   
        $inscription = new Inscription();
        $inscription->nom = $request['nom'];
        $inscription->prenom = $request['prenom'];
        $inscription->telephone1 = $request['telephone1'];
        $inscription->telephone2 = $request['telephone2'];
        $inscription->photo = $request['photo'];
        $inscription->naissance = $request['naissance'];
        $inscription->niveau = $request['niveau'];
        $inscription->matieres = json_encode($request['matieres']);
        $inscription->save();
        

        if($request->file('photo')){
            // dd('sa');
            $file = $request->file('image');
            $image = $file->store(
                'membres/images',
                'public'
            );
            $inscription->photo= $image;     
        }

        session()->flash('notification.message' , 'Dawra : '.$request->matiere.' , '.$request->niveau.' Prof : '.$request->prof.' ajoutée avec succés');
        session()->flash('notification.type' , 'success'); 
        return back();
    	# code...
    }

}
