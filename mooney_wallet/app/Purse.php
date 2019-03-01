<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Purse extends Model
{

    protected $fillable = [
        'id', 'name', 'user_id', 'type',
    ];

    public function batch_insert_data($data){

        if(empty($data)){
            return false;
        }

        return DB::table('purses')->insert($data);

    }

}
