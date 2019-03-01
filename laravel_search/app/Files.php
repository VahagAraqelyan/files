<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class  Files extends Model {


    public function insert_data($data){

        if(empty($data)){

            return false;
        }

         return DB::table('files')->insert($data);

    }

}