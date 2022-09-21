<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seancesdawra extends Model
{
    protected $fillable = [
        'id_eleve',
        'id_dawra',
        'num_seance',
        'presence'
    ];

}
