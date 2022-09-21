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


class Classe extends Model
{

	public static function all_classes()
	{

		$all_classes = (DB::select("select * from classes where visible =1 order by num"));

		return $all_classes;
		# code...
	}

	public static function last_ids()
	{

		$all_classes = (DB::select("select * from classes where visible =1 order by id desc"));

		if (count($all_classes)==0) 
		{
		
			return 0;
			
			# code...
		}
		else
		{

			return $all_classes[0]->id;			

			# code...	
		}


		# code...
	}

	public static function what_exists($salle,$horaires,$le_jour)
	{

		$salle = $salle->num;
		
		$jours = [];
		$i=0;
		
		foreach ($le_jour as $l_jour) 
		{
		 	
			if (strtoupper($l_jour->classe) == strtoupper($salle)) 
			{
				
				$jours[$i] = (object)['heure_debut' => $l_jour->heure_debut,'heure_fin' => $l_jour->heure_fin];

				$jourss[$i] = $l_jour;

				$i++;
				
				//
			}

		 	// code...
		} 

		$le_jour = $jours;

		$to_return = [];

		$k=0;

		for ($i=0; $i < count($horaires) ; $i++) 
		{ 
			
			if (in_array($horaires[$i],$le_jour)) 
			{

				$to_return[$i] = $jourss[$k];

				$k++;

				//
			}
			else
			{

				$to_return[$i] = (object)['prof' => 'vide','matiere' => 'vide','niveau' => 'vide'];

				//
			}

			//
		}		

		return $to_return;
		
		//
	}


    //use HasFactory;
}
