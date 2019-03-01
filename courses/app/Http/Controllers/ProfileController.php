<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {

        if(!Auth::check()){

            return redirect()->route('login');
        }

        return view('profile/profilePage');
    }

    public function ax_save_user_info(Request $request){

       $name = $request->name;

        $data['inf']  = [];
        $data['errors'] = [];

        $user_info = Auth::user();

        $image = $request->file('user_photo');

        if(empty($image)){
            $update_data = [
                'name' => $name
            ];

            User::where('id',Auth::user()->id)
                ->update($update_data);

            return json_encode($data);
        }

        if(!empty($user_info->user_avatar)){

            $path = 'user/'.$user_info->id.'/'.$user_info->user_avatar;

            $result = $this->delete_image($path);
        }

        $image_name = Str::random(8).$image->getClientOriginalName();

        $upload_success = $image->move(public_path('user/'.$user_info->id.'/'),$image_name);

        if ($upload_success) {

            $data['inf'] = asset('user/'.$user_info->id.'/'.$image_name);

            echo json_encode($data);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }

        $update_data = [
            'name' => $name,
            'user_avatar' => $image_name
        ];

        User::where('id',Auth::user()->id)
            ->update($update_data);
    }

    public function ax_delete_avatar(){

        $user_info = Auth::user();

        $data['errors'] = [];

        if(empty($user_info->user_avatar)){

            $data['errors'][] = 'You have not avatar';

            return json_encode($data);
        }

        $path = 'user/'.$user_info->id.'/'.$user_info->user_avatar;

        $this->delete_image($path);

        $update_data = [
            'user_avatar' => ''
        ];

        User::where('id',Auth::user()->id)
            ->update($update_data);

        $data['path'] = asset('img');

        echo json_encode($data);
    }

    public function ax_check_password(Request $request){

        $password = $request->password;

        $password = Hash::make('secret');

       $data['check'] = true;

       if(!Hash::check('secret', $password)){
           $data['check'] = false;
       }

       echo json_encode($data);
    }

    public function ax_change_email(Request $request){

        $new_email = $request->email;

        $data['errors'] = [];
        $data['message'] = [];

        $users = User::where('id', '!=', Auth::id())->get();

        if(!empty($users)){

            foreach ($users as $single){

                if($single->email == $new_email){
                    $data['errors'][] = 'This email is already exist';
                    break;
                }
            }
        }

        if(!empty($data['errors'])){

            return json_encode($data);
        }

       User::where('id',Auth::user()->id)
            ->update(['email' => $new_email]);

        Auth::login(Auth::user());

        $data['message'][] = 'Your email has ben changed';
        echo json_encode($data,JSON_HEX_APOS | JSON_HEX_QUOT);
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