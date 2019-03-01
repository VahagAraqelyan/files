<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Str;
use App\Lesson;
use App\Lesson_images;
use App\Subject_type;

class LessonController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function add_lesson(){

        $data['subject_type'] = DB::table('subject_type')->get()->toArray();

        return view('admin/lesson/add_lesson',$data);
    }

    public function all_lesson(){

        $data['all_lesson'] = Lesson::with('subject_type')->get()->toArray();

        return view('admin/lesson/all_lesson',$data);
    }

    public function upload_file(Request $request){

        $data['inf']  = [];

        $image = $request->file('file');

        $image_name = Str::random(8).'.png';

        $upload_success = $image->move(public_path('images'),$image_name);

        if ($upload_success) {

            $data['inf'] = $image_name;

           echo json_encode($data);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }
    }

    public function ax_save_lesson(Request $request){

        $data['errors'] = [];

        $image_name      = $request->image_name;
        $name            = $request->name;
        $title           = $request->title;
        $subject_type_id = $request->subject_type_id;
        $video_name      = $request->video_name;
        $lesson_text     = $request->lesson_text;
        $lesson_type     = $request->lesson_type;
        $status          = $request->status;

      /*  $data['errors'] = [];

        if(empty($image_name)){

        }*/

        $lesson_arr = [
            'name'            => $name,
            'title'           => $title,
            'subject_type_id' => $subject_type_id,
            'lesson_text'     => $lesson_text,
            'lesson_video'    => $video_name,
            'type'            => $lesson_type,
            'status'          => $status,
        ];

        $image_arr = explode(",", $image_name);

        $lesson = new Lesson();
        $image = new Lesson_images();

        $lesson_result = $lesson->insert_data($lesson_arr);

        $new_img_arr = [];

        foreach ($image_arr as $single){
            $new_img_arr = [
                'image_name' => $single,
                'lesson_id' => $lesson_result,
            ];

             $image_result = $image->batch_insert($new_img_arr);
         }

        echo json_encode($data);
    }

    public function ax_upload_video(Request $request){

        $data['inf']  = [];

        $image = $request->file('lesson_video');

        $image_name = Str::random(8).$image->getClientOriginalName();

        $upload_success = $image->move(public_path('videos'),$image_name);

        if ($upload_success) {

            $data['inf'] = $image_name;

            echo json_encode($data);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }
    }

    public function ax_update_lesson(Request $request){

        $check_arr = $request->check_arr;

        $data['errors'] = [];

        if(empty($check_arr)){

            return $data['errors'][] = 'Please set subject(s)';
        }

        $data['subject_type'] = DB::table('subject_type')->get();

        foreach ($check_arr as $index => $val){

            $data['all_lesson'][]= Lesson::with('subject_type','lesson_img')->where('id',$val)->first()->toArray();
        }

        return view('admin/lesson/edit_lesson_answer',$data);
    }

    public function ax_save_update_lesson(Request $request){

        $name = $request->name;
        $title = $request->title;
        $lesson_type = $request->lesson_type;
        $subject_type_id = $request->subject_type_id;
        $lesson_time = $request->lesson_time;
        $status = $request->status;
        $lesson_text = $request->lesson_text;

        foreach ($name as $index => $value){

            if(empty($value)){

                continue;
            }

            $updatet_data = [
                'name'            => $value,
                'title'           => $title[$index],
                'subject_type_id' => $subject_type_id[$index],
                'type'            => $lesson_type[$index],
                'lesson_text'     => $lesson_text[$index],
                'lesson_time'     => $lesson_time[$index],
                'status'          => $status[$index]
            ];

            Lesson::where('id',$index)
                ->update($updatet_data);
        }

        echo json_encode(true);
    }

    public  function ax_delete_lesson(Request $request){

        $check_arr = $request->check_arr;

        $data['errors'] = [];

        if(empty($check_arr)){

            return $data['errors'][] = 'Please set subject(s)';
        }


        foreach ($check_arr as $index => $val){

            Lesson::select()->where('id',$val)->delete();
        }
    }
}
