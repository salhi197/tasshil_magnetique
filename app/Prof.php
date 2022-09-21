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

class Prof extends Model
{

	public static function all_profs()
	{

		$all_profs = (DB::select("select * from profs where visible =1 order by nom"));

		return $all_profs;
		# code...
	}

	public static function last_ids()
	{

		$all_profs = (DB::select("select * from profs where visible =1 order by id desc"));

		if (count($all_profs)==0) 
		{
		
			return 0;
			
			# code...
		}
		else
		{

			return $all_profs[0]->id;			

			# code...	
		}


		# code...
	}


    //use HasFactory;


    //use HasFactory;
}
