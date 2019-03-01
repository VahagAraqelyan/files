<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Right_answer extends Model
{
    protected $table = 'right_answers';

    public function right_answer(){

        return $this->hasMany('App\Lesson','id', 'lesson_id');
    }
}
