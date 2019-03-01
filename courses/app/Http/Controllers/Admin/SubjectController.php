<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Subjects;

class SubjectController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function add_subject(){

        return view('admin/subject/add_subject');
    }

    public function ax_save_subject(Request $request){

        $name = $request->name;

        $data['errors'] = [];

        if(empty($name)){
            $data['errors'][] = 'Name is required';
            echo json_encode($data);
            return false;
        }

        $subject = new Subjects();

        $result = $subject->insert_data(['name' => $name]);

        echo json_encode($data);
    }

    public function subject_type(){

        $data['subjects'] = Subjects::select()->get()->toArray();

        return view('admin/subject/add_subject_type',$data);
    }

    public function ax_save_subject_type(Request $request){

        $name = $request->nameInp;
        $subject_id = $request->subject_id;

        $data['errors'] = [];

        if(empty($name)){
            $data['errors'][] = 'Name is required';

            return json_encode($data);
        }

        if(empty($subject_id)){
            $data['errors'][] = 'Subject is required';
            return json_encode($data);
        }

        $subject = new Subjects();

        $result = $subject->insert_subject_type(['name' => $name,'subject_id'=>$subject_id]);

        echo json_encode($data);
    }

    public function all_subject(){

        $data['subjects'] = Subjects::select()->get()->toArray();

        return view('admin/subject/all_subject',$data);
    }

    public function all_subject_type(){

        $data['subject_type'] = DB::table('subject_type')->get()->toArray();
        return view('admin/subject/all_subject_type',$data);
    }

    public function ax_update_subject(Request $request){

        $check_arr = $request->check_arr;

        $data['errors'] = [];

        if(empty($check_arr)){

            return $data['errors'][] = 'Please set subject(s)';
        }

        foreach ($check_arr as $index => $val){

            $data['subject'][] = Subjects::select()->where('id',$val)->first()->toArray();
        }

        return view('admin/subject/edit_subject_answer',$data);
    }

    public function ax_save_edit_subject(Request $request){

        $sub = $request->subj_name;

        foreach ($sub as $index => $value){

            if(empty($value)){

                continue;
            }

            Subjects::where('id',$index)
                ->update(['name' => $value]);
        }

        echo json_encode(true);
    }

    public function ax_delete_subject (Request $request){

        $check_arr = $request->check_arr;

        $data['errors'] = [];

        if(empty($check_arr)){

            return $data['errors'][] = 'Please set subject(s)';
        }


        foreach ($check_arr as $index => $val){

            Subjects::select()->where('id',$val)->delete();
        }
    }

    public function ax_update_subject_type(Request $request){

        $check_arr = $request->check_arr;

        $data['errors'] = [];

        if(empty($check_arr)){

            return $data['errors'][] = 'Please set subject(s) type';
        }

        foreach ($check_arr as $index => $val){

            $data['subject_type'][] = DB::table('subject_type')->where('id',$val)->first();
        }

        return view('admin/subject/edit_subject_type_answer',$data);
    }

    public function ax_save_edit_subject_type(Request $request){

        $sub = $request->subj_name;

        foreach ($sub as $index => $value){

            if(empty($value)){

                continue;
            }

            DB::table('subject_type')
                ->where('id', $index)
                ->update(['name' => $value]);
        }

        echo json_encode(true);
    }

    public function ax_delete_subject_type(Request $request){

        $check_arr = $request->check_arr;

        $data['errors'] = [];

        if(empty($check_arr)){

            return $data['errors'][] = 'Please set subject(s)';
        }


        foreach ($check_arr as $index => $val){

            DB::table('subject_type')->where('id',$val)->delete();
        }
    }
}
