<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\user;
use App\record;
use App\purse;

class RecordsController extends Controller
{
    /**
     * Show the application all records page.
     */
    public function index(){

        $id = Auth::user()->id;

        $data['records'] = record::select()->where('user_id', $id)->get()->toArray();

        return view('all_records',$data);
    }

    /**
     * Show the application add records page.
     */
    public function add_records(){

        $this->check_login();

        $id = Auth::user()->id;

        $data['wallets'] = purse::select()->where('user_id', $id)->get()->toArray();

        return view('add_records',$data);
    }

    /**
     * Added new records
     * @return bool
     */
    public function ax_save_records(Request $request){

        $this->check_login();

        $name        = $request->input('name');
        $record_type = $request->input('record_type');
        $wallet_type = $request->input('wallet_type');
        $price       = $request->input('price');

        $data['success'] = [];
        $data['errors'] = [];

        if(empty($name) || empty($record_type) || empty($wallet_type) || empty($price)){
            $data['errors'][] = 'Incorrect information.';
            echo json_encode($data);
            return false;
        }

        $id = Auth::user()->id;

        $insert_data = [
            'name'         => $name,
            'wallet_id'    => $wallet_type,
            'user_id'      => $id,
            'records_type' => $record_type,
            'amount'       => $price
        ];

        $record = new Record();
        $result = $record->insert_data($insert_data);

        if($result){
            $data['success'][] = 'Data successfuly saved';
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

            return redirect('/login');
        }

        if($ajax){

            if(!Request::ajax())
            {
                return redirect('/login');
            }
        }

        return true;
    }
}
