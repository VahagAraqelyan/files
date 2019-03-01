<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Eloquent;

class Answer extends Eloquent
{

    protected $table = 'answer';
    public $timestamps = false;
}
