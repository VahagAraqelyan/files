<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson_images extends Model
{

    protected $table = 'lesson_img';

    public function batch_insert($data){

        if(empty($data)){
            return false;
        }

        return DB::table('lesson_img')->insert($data);
    }
}
