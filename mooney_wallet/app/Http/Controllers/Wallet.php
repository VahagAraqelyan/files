<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\user;
use App\purse;
use App\record;

class Wallet extends Controller
{

    /**
     * Show the application all wallet page.
     */

    public function index(){

        $this->check_login();

        $id = Auth::user()->id;


        $wallets = purse::select()->where('user_id', $id)->get()->toArray();

        foreach ($wallets as $index => $val){

            $wall_amount = 0;
            $wallets[$index]['amount'] = 0;

            $records = record::select()->where(['user_id'=> $id, 'wallet_id' =>$val['id']])->get()->toArray();

            if(empty($records)){
                continue;
            }

            foreach ($records as $single){

                if($single['records_type'] == 1){
                    $wall_amount+= $single['amount'];

                }else{
                    $wall_amount-=$single['amount'];
                }

            }

            $wallets[$index]['amount'] = $wall_amount;
        }

        $data['wallets'] = $wallets;

        return view('all_wallet',$data);
    }

    /**
     * Show the application add wallet page.
     */

    public function addWallet(){

        $this->check_login();

        return view('add_wallet');
    }


    /**
     * Added new wallet
     * @return bool
     */
    public function ax_save_wallet(Request $request){

        $this->check_login();

        $names = $request->input('names');
        $types = $request->input('types');

        $data['success'] = [];
        $data['errors'] = [];

        if(!is_array($names) || !is_array($types)){
            $data['errors'][] = 'Incorrect information.';
            echo json_encode($data);
            return false;
        }

        $batch_insert_data = [];

        $names = array_filter($names);
        $types = array_filter($types);

        $id = Auth::user()->id;

        foreach ($names as $index => $value){

            $batch_insert_data[] = [
             'name'    => $names[$index],
             'type'    => $types[$index],
             'user_id' => $id
            ];
        }

        $purse = new Purse();

        $result = $purse->batch_insert_data($batch_insert_data);

        if($result){

            $data['success'] = 'Data successfuly saved';
        }

        echo json_encode($data);
    }

    /**
     * check user login.
     *
     * @return bool
     */
    private function check_login($ajax = NULL){

        if (!Auth::check()) {

            return false;
        }

        if($ajax){

            if(!Request::ajax())
            {
                return false;
            }
        }

        return true;
    }
}
