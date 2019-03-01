<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plans;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\User;

class PricingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function pricing_plan(){

        $user_info = Auth::user();

        if(!empty($user_info['plan_id'])){

            return redirect('home');
        }

        $plans_class = new Plans();

        $plans = $plans_class->get_all_plan();

        $data['plans'] = $plans;

        return view('pricing/pricing_plan',$data);
    }

    public function change_plan(){

        if(!Auth::check()){

            return redirect()->route('login');
        }

        $plans_class = new Plans();

        $plans = $plans_class->get_all_plan();

        $data['plans'] = $plans;

        return view('pricing/change_plan',$data);
    }

    public function get_plan($id,$action){

        if(empty($id) || empty($action)){
            return false;
        }

        if (Auth::check() && empty($user_info['plan_id'])) {

            $user_info = Auth::user();

            $user_info['plan_id'] = $id;

            $user_info->save();

            return redirect()->route('home');
        }

        Cookie::queue('plan_id', $id, 60);

        return redirect()->route($action);
        //dd(Cookie::get('plan_id'));
    }

    public function ax_save_check(Request $request){

        $data['errors'] = [];

        $image = $request->file('check_photo');

        $user_info = Auth::user();

        $image_name = Str::random(8).$image->getClientOriginalName();

        $upload_success = $image->move(public_path('user/'.$user_info->id.'/'),$image_name);

        if(!empty($user_info->charge_check)){

            $path = 'user/'.$user_info->id.'/'.$user_info->charge_check;

            $result = $this->delete_image($path);
        }

        if ($upload_success) {
            $data['inf'] = asset('user/'.$user_info->id.'/'.$image_name);

            echo json_encode($data);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }

        User::where('id',Auth::user()->id)
            ->update(['charge_check' => $image_name]);
    }

    public function ax_change_premium(Request $request){

        $plan_id = $request->plan_id;

        $data['errors'][] = [];

        if(empty($plan_id)){
            $data['errors'][] = 'Please set plans';

            return json_encode($data);

        }

        User::where('id',Auth::user()->id)
            ->update(['plan_id' => $plan_id]);

        echo json_encode($data);
    }

    public function delete_image($path){

        if(empty($path)){
            return false;
        }

        if(!file_exists(public_path($path))){
            return false;
        }

        return unlink(public_path($path));
    }
}