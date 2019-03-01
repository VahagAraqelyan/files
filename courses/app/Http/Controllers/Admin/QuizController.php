<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Plans;
use App\Quiz;
use App\training_example;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Subjects;
use App\Right_answer;

class QuizController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function add_quiz()
    {

        $data['lesson'] = Lesson::select()->where('type',2)->get()->toArray();
        $data['example'] = training_example::select()->get()->toArray();

        return view('admin/quiz/add_quiz', $data);
    }

    public function all_quiz()
    {

        $data['quiz'] = Quiz::with('answer')->get()->toArray();

        return view('admin/quiz/all_quiz', $data);
    }

    public function add_example()
    {

        $data['subjects'] = Subjects::select()->get()->toArray();

        return view('admin/quiz/add_example', $data);
    }

    public function ax_update_quiz(Request $reques){

        $id = $reques->id;

        $data['errors'] = [];
        $data['answer'] = [];

        if(empty($id)){

            $data['errors'][] = 'Please try again';

            return json_encode($data);
        }

        $data['quiz'] = Quiz::with('answer')->where('id',$id)->first()->toArray();

        return view('admin/quiz/edit_quiz_answer', $data);
    }

    public function ax_save_update_quiz(Request $request){

        $right_answer = $request->right_answer;
        $answers = $request->answer;
        $id = $request->id;

        Quiz::where('id',$id)
            ->update(['right_answer_id' =>$right_answer]);

        foreach ($answers as $index => $val){

            Answer::where('id',$index)
                ->update(['answer' =>$val]);
        }
    }

    public function ax_upload_updatet_quiz_file(Request $request){

        $image = $request->file('file');

        $id = $request->id;

        if(empty($image) || empty($id)){

            return json_encode(false);
        }

        $image_name = Str::random(8) .'.png';

        $upload_success = $image->move(public_path('quiz_images'), $image_name);

        if ($upload_success) {

            Quiz::where('id',$id)
                ->update(['quiz_name' =>$image_name]);
        } // Else, return error 400
        else {
            return response()->json('error', 400);
        }

        $quiz = Quiz::select()->where('id',$id)->first()->toArray();

        File::delete('quiz_images/'.$quiz['quiz_name']);
        return json_encode(true);
    }

    public function ax_save_exam(Request $request)
    {

        $data['errors'] = [];
        $data['answer'] = [];

        $name = $request->exam_name;
        $subject_id = $request->subject_id;
        $description = $request->description;

        if (empty($name)) {
            $data['errors'][] = 'Please set exam name';

            return json_encode($data);
        }

        if (empty($subject_id)) {
            $data['errors'][] = 'Please set subject';

            return json_encode($data);
        }


        $insert_data = [
            'name' => $name,
            'subject_id' => $subject_id,
            'description' => $description,
        ];

        $result = training_example::insert($insert_data);

        if (!$result) {
            $data['errors'][] = 'Data not saved. Please try again.';
        }

        echo json_encode($data);

    }

    public function ax_save_quiz(Request $request)
    {

        $data['errors'] = [];
        $data['answer'] = [];

        $name = $request->name;
        $answer = $request->answer;
        $lesson = $request->lesson;
        $quiz_type = $request->quiz_type;
        //$subject_id = $request->subject_id;
        $right_answer = $request->right_answer;

        if (empty($answer)) {
            $data['errors'][] = 'Please set answer(s)';
            return json_encode($data);
        }


        if (empty($name)) {
            $data['errors'][] = 'Please set name(s)';

            return json_encode($data);
        }

        $quiz_data = [
            'quiz_name' => $name,
            'lesson_id' => $lesson,
            'status' => $quiz_type,
            //'subject_id' => $subject_id,
        ];

        $answer_data = [];
        $right_answer_id = 0;

        $quiz = new Plans();

        $quiz_id = $quiz->insert_quiz($quiz_data);

        if (empty($quiz_id)) {

            $data['errors'][] = 'Data not saved. Please try again.';

            return json_encode($data);
        }

        foreach ($answer as $index => $single) {

            $answer_data = [
                'quiz_id' => $quiz_id,
                'answer' => $single
            ];

            $result = $quiz->insert_answer($answer_data);

            if ($index == $right_answer) {

                $right_answer_id = $result;
            }
        }

        $lesson_result = DB::table('quiz')
            ->where('id', $quiz_id)
            ->update(['right_answer_id' => $right_answer_id]);


        if (empty($result)) {

            $data['errors'][] = 'Data not saved. Please try again.';
            return json_encode($data);
        }

        echo json_encode($data);
    }

    public function ax_upload_quiz_file(Request $request)
    {

        $data['inf'] = [];

        $image = $request->file('question_file');

        $image_name = Str::random(8). '.png';

        $upload_success = $image->move(public_path('quiz_images'), $image_name);

        if ($upload_success) {

            $data['image_name'] = $image_name;

            echo json_encode($data);
        } // Else, return error 400
        else {
            return response()->json('error', 400);
        }
    }

    public function ax_save_quiz_answer(Request $request)
    {

        $answers = $request->answers;
        $less_id = $request->less_id;

        $data['errors'] = [];
        $data['right_answer'] = [];

        $post_data = [];
        $insert_arr = [];
        $right_answer_count = 0;
        $all_count = 0;

        if (empty($answers)) {

            $data['all_count'] = $all_count;
            $data['right_answer_count'] = $right_answer_count;

            $insert_arr = [
                'user_id' => Auth::user()->id,
                'all_count' => $all_count,
                'right_answer_count' => $right_answer_count,
                'lesson_id' => $less_id,
                'status' => 1,
            ];

            Right_answer::insert($insert_arr);

            return json_encode($data);
        }

        foreach ($answers as $index => $val) {

            $post_data = explode('->', $val);

            if (count($post_data) != 2) {
                continue;
            }

            $quiz = DB::table('quiz')->where('id', $post_data[0])->first();

            $lesson = DB::table('lesson')->where('id', $quiz->lesson_id)->first();

            if (empty($lesson)) {
                $data['errors'] = 'Invalid data. Please try again';

                return json_encode($data);
            }

            if ($quiz->right_answer_id == $post_data[1]) {

                $right_answer_count++;

                $data['right_answer'][] = [
                    'quiz_id' => $post_data[0],
                    'answer_id' => $post_data[1],
                    'right_answer_id' => $quiz->id . '->' . $quiz->right_answer_id
                ];
            } else {

                $data['wrong_answer'][] = [
                    'quiz_id' => $post_data[0],
                    'answer_id' => $post_data[1],
                    'right_answer_id' => $quiz->id . '->' . $quiz->right_answer_id
                ];
            }

            $all_count++;
        }

        $data['lesson_title'] = $lesson->name;
        $data['all_count'] = $all_count;
        $data['right_answer_count'] = $right_answer_count;

        $insert_arr = [
            'user_id' => Auth::user()->id,
            'lesson_id' => $less_id,
            'all_count' => $all_count,
            'right_answer_count' => $right_answer_count,
            'status' => 1,
        ];

        DB::table('right_answers')->insert($insert_arr);

        echo json_encode($data);

    }
}
