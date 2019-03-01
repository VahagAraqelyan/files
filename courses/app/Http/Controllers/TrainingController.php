<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Right_answer;
use App\training_example;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subjects;

class TrainingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {

            return redirect()->route('login');
        }

        $data['subjects'] = Subjects::with('training_exam')->get();

        return view('training/training_room',$data);
    }

    public function example($id){

        if (!Auth::check()) {

            return redirect()->route('login');
        }

        $data['quizes'] = Quiz::with('answer')->where('example_id',$id)->get();

        $data['exam'] = training_example::select()->where('id',$id)->first()->toArray();

        return view('training/example',$data);

    }

    public function ax_save_exam_answer(Request $request){

        $answers = $request->answers;
        $exam_id = $request->exam_id;

        $data['errors'] = [];
        $data['right_answer'] = [];

        $post_data = [];
        $insert_arr = [];
        $right_answer_count = 0;
        $all_count = 0;

        if(empty($answers)){

            $data['all_count']          = $all_count;
            $data['right_answer_count'] = $right_answer_count;

            $insert_arr = [
                'user_id'            => Auth::user()->id,
                'all_count'          => $all_count,
                'right_answer_count' => $right_answer_count,
                'exam_id'            => $exam_id,
                'status'             => 2,
            ];

            $result =  Right_answer::insert($insert_arr);

            return json_encode($data);
        }

        foreach ($answers as $index => $val){

            $post_data = explode('->',$val);

            if(count($post_data) != 2){
                continue;
            }

            $quiz = DB::table('quiz')->where('id', $post_data[0])->first();

            $exam = DB::table('training_examples')->where('id', $quiz->example_id)->first();

            if(empty($exam)){
                $data['errors'] = 'Invalid data. Please try again';

                return json_encode($data);
            }

            if($quiz->right_answer_id == $post_data[1]){

                $right_answer_count ++;

                $data['right_answer'][] = [
                    'quiz_id'         => $post_data[0],
                    'answer_id'       => $post_data[1],
                    'right_answer_id' => $quiz->id.'->'.$quiz->right_answer_id
                ];
            }else{

                $data['wrong_answer'][] = [
                    'quiz_id'         => $post_data[0],
                    'answer_id'       => $post_data[1],
                    'right_answer_id' => $quiz->id.'->'.$quiz->right_answer_id
                ];
            }

            $all_count ++;
        }

        $data['all_count']          = $all_count;
        $data['right_answer_count'] = $right_answer_count;

        $insert_arr = [
            'user_id'            => Auth::user()->id,
            'all_count'          => $all_count,
            'right_answer_count' => $right_answer_count,
            'exam_id'            => $exam->id,
            'status'             => 2,
        ];

        $result =  Right_answer::insert($insert_arr);

        if(!$result){
            $data['errors'][] = 'Data not saved. Please try again.';
        }

       echo json_encode($data);
    }



}
