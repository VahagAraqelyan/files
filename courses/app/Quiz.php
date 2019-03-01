<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Eloquent;

class Quiz extends Eloquent
{

    protected $table = 'quiz';
    public $timestamps = false;
    public function insert_quiz($data){

        if(empty($data)){
            return false;
        }

         DB::table('quiz')->insert($data);

        return DB::getPdo()->lastInsertId();
    }

    public function insert_answer($data){

        if(empty($data)){
            return false;
        }

        DB::table('answer')->insert($data);

        return DB::getPdo()->lastInsertId();
    }

    public function get_quiz_answer(){

        return DB::table('lesson')->get();
    }

    public function answer(){

        return $this->hasMany('App\Answer','quiz_id', 'id');
    }
}
