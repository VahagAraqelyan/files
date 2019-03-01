<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class training_example extends Model
{
    protected $table = 'training_examples';


    public function quiz(){
        return $this->hasMany('App\Quiz','example_id', 'id');
    }
}
