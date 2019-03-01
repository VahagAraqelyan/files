<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plans extends Model
{

    public function get_all_plan(){

       $result =  DB::table('plans')
            ->leftJoin('plan_types', 'plan_types.id', '=', 'plans.plan_type_id')
            ->get();

       return $result;
    }

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

    public function get_quiz_answer($id){

        $result =  DB::table('answer')->where('quiz_id',$id)->get();

        return $result;
    }
}
