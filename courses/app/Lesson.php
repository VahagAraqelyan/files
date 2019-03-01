<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    protected $table = 'lesson';
    public $timestamps = false;
    public function insert_data($data){

        if(empty($data)){
            return false;
        }

         DB::table('lesson')->insert($data);

        return DB::getPdo()->lastInsertId();
    }

    public function get_lesson(){

        return DB::table('lesson')->get();
    }

    public function subject_type(){

        return $this->hasMany('App\Subject_type','id', 'subject_type_id');
    }

    public function lesson_img(){

        return $this->hasMany('App\Lesson_images','lesson_id', 'id');
    }


}
