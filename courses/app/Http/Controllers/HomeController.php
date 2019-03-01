<?php

namespace App\Http\Controllers;

use App\Right_answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subjects;
use App\Lesson_images;
use App\Lesson;
use App\User_courses;
use App\Html_template;
class HomeController extends Controller
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
        $this->middleware('auth');

        $user_info = Auth::user();

        if(empty($user_info['plan_id']) && !empty(Cookie::get('plan_id'))){

            $user_info['plan_id'] = Cookie::get('plan_id');

            $user_info->save();
        }

        if(empty($user_info['plan_id']) && empty(Cookie::get('plan_id'))){

            return redirect()->route('pricing_plan');
        }

        $data['subjects'] = Subjects::all()->toArray();

        $data['subject_type'] = DB::table('subject_type')->get();

/*        $data['lesson'] = DB::table('lesson')
            ->leftJoin('subject_type', 'subject_type.id', '=', 'lesson.subject_type_id')
            ->leftJoin('lesson_img', 'lesson_img.lesson_id', '=', 'lesson.id')
            ->select('subject_type.name AS subject_name', 'lesson.*','lesson_img.image_name')
            ->get();*/

        $data['lesson'] = Lesson::with('subject_type','lesson_img')->get()->toArray();

        $data['lesson_img'] = DB::table('lesson_img')->get();

        $data['quiz'] = DB::table('quiz') ->where('status','1')->get();

        $data['answer'] =DB::table('quiz')
            ->leftJoin('answer', 'quiz.id', '=', 'answer.quiz_id')
            ->select('answer.*')
            ->where('status','1')
            ->get();

        $data['right_answer'] = Right_answer::with('right_answer')->where('user_id',Auth::user()->id)->where('status',1)->get()->toArray();

        return view('home',$data);
    }

    public function ax_ordering_subject(Request $request){

        $sub_id   = $request->sub_id;
        $asc_desc = $request->asc_desc;

        if(empty($sub_id) || empty($asc_desc)){
            return json_encode('error');
        }

        $data['lesson'] = DB::table('lesson')
            ->leftJoin('subject_type', 'subject_type.id', '=', 'lesson.subject_type_id')
            ->leftJoin('lesson_img', 'lesson_img.lesson_id', '=', 'lesson.id')
            ->select('subject_type.name AS subject_name', 'lesson.*','lesson_img.image_name')
            ->orderBy('lesson.id', $asc_desc)
            ->where('lesson.subject_type_id', $sub_id)
            ->get();

        $data['right_answer'] = Right_answer::with('right_answer')->where('user_id',Auth::user()->id)->where('status',1)->get()->toArray();

        $data['sub_id'] = $sub_id;

        return view('lesson_answer',$data);
    }

    public function contact(){
       $data['template'] = Html_template::select()->where('title','contact')->first()->toArray();
        return view('contact',$data);
    }

    public function about_us(){
        $data['template'] = Html_template::select()->where('title','about_us')->first()->toArray();
        return view('about_us',$data);
    }

    public function main(){

        $data['template'] = Html_template::select()->where('title','main')->first()->toArray();
        return view('main',$data);
    }

    public function faq(){

        $data['template'] = Html_template::select()->where('title','faq')->first()->toArray();
        return view('faq',$data);
    }

    public function reset_password(){

        return view('auth/passwords/email');
    }

    public function ax_open_course(){

        $id = Auth::user()->id;

    }
}
