<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use App\Http\Requests;

class Home extends Controller
{

    public function index(){

        $prod =Files::select()->get()->toArray();
       return  view('home')->with(['prod' => $prod]);
    }

    public function add_file(){

        return  view('add_file');

    }

    public function ax_save_file(Request $request){

        $file_name = $request->input('file_name');

        if(empty($file_name)){

            echo json_encode(false);
            return false;
        }

        $path = $request->file('upload_file')->store('avatars');

        $insert_data = [
            'name'  => $file_name,
            'image' => $path,
        ];

        $auth = new Files();
        echo  json_encode($auth->insert_data($insert_data));
    }

    public function ax_search_file(Request $request){

        $search_str = $request->input('search');

        if(empty($search_str)){

            $prod =Files::select()->get()->toArray();
            return  view('search_answer')->with(['prod' => $prod]);
        }

        $prod = Files::select()->where('name', 'like', '%'.$search_str.'%')->get()->toArray();

        return  view('search_answer')->with(['prod' => $prod]);
    }
}
