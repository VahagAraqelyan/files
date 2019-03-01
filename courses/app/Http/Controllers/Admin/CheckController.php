<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function get_all_user_check(){

        $data['users'] = User::select()->get()->toArray();

        return view('admin/check/all_user_check',$data);
    }

    public function ax_check_coupon(Request $request){

        $user_arr = $request->users;

        foreach ($user_arr as $single){

            $data['users'][] = User::select()->where('id',$single)->first()->toArray();
        }

        return view('admin/check/check_coupon_answer',$data);
    }

    public function ax_delete_user(Request $request){

        $user_arr = $request->users;

        foreach ($user_arr as $single){

            User::select()->where('id',$single)->delete();
        }
    }

    public function ax_save_check_coupon(Request $request){

        $check = $request->check_coupon;
        $name  = $request->name;
        $email = $request->email;
        $shcool_year = $request->shcool_year;

        foreach ($check as $index => $value){

            if(empty($value)){

                continue;
            }

            User::where('id',$index)
                ->update([
                    'payment_charge' => $value,
                    'name'           => $name[$index],
                    'email'          => $email[$index],
                    'shcool_year'    => $shcool_year[$index],
                ]);
        }

        return json_encode(true);
    }


    public function add_user(){

        return view('admin/user/add_user');
    }

    public function ax_save_user(Request $request){

        $name        = $request->name;
        $email       = $request->email;
        $pass        = $request->password;
        $shcool_year = $request->shcool_year;

        $data['errors'] = [];

        $user = User::select()->where('email',$email)->first();

        if(!empty($user)){
            $data['errors'][] = 'Email already exist';
            return json_encode($data);
        }

         User::create([
            'name'        => $name,
            'email'       => $email,
            'shcool_year' => $shcool_year,
            'password'    => bcrypt($pass),
        ]);

         return json_encode(true);
    }
}
