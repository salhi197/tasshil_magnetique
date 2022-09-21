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


class Niveau extends Model
{

    public static function all_niveaux()
    {

        $all_niveaux = (DB::select("select * from niveaux where visible =1 order by cycle,niveau"));

        return $all_niveaux;
        # code...
    }

    public static function last_ids()
    {

        $all_niveaux = (DB::select("select * from niveaux /*where visible =1*/ order by id desc"));

        if (count($all_niveaux)==0) 
        {
        
            return 0;
            
            # code...
        }
        else
        {

            return $all_niveaux[0]->id;         

            # code...   
        }


        # code...
    }


    //use HasFactory;
}
