<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Eloquent;

class Subjects extends Eloquent
{

    public $timestamps = false;

    public function insert_data($data){

        if(empty($data)){
            return false;
        }

        return DB::table('subjects')->insert($data);
    }

    public function insert_subject_type($data){

        if(empty($data)){
            return false;
        }

        return DB::table('subject_type')->insert($data);
    }

    public function training_exam(){
        return $this->hasMany('App\training_example','subject_id', 'id');
    }
}
