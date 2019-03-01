<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record extends Model
{

    public function insert_data($data){

        if(empty($data)){
            return false;
        }

        return DB::table('records')->insert($data);

    }
}
