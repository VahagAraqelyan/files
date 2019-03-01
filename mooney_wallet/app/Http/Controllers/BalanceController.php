<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\user;
use App\purse;
use App\record;

class BalanceController extends Controller
{
    public function index(){

        if (!Auth::check()) {

            return redirect('/login');
        }

        $id = Auth::user()->id;
        $wall_amount = 0;

        $records = record::select()->where('user_id', $id)->get()->toArray();

        foreach ($records as $single){

            if($single['records_type'] == 1){
                $wall_amount+= $single['amount'];

            }else{
                $wall_amount-=$single['amount'];
            }

        }

        $data['balance'] = $wall_amount;

        return view('balance',$data);
    }
}
