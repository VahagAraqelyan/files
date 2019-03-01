<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\user;
use App\purse;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->check_login();

        return view('home');
    }

    /**
     * check wallet.
     *
     * @return bool
     */
    public function ax_check_wallet(Request $request){


        $data['bool'] = true;

        $this->check_login();

        $id = Auth::user()->id;

        $wallet = Purse::Where('user_id',$id)->first();

        if(empty($wallet)){

            $data['bool'] = false;
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

    public function createPdf(){

        $pdf = App::make('dompdf.wrapper');

        $pdf->setOptions(['enable-javascript'=> true,'javascript-delay'=>13500,'enable-smart-shrinking'=>true,'no-stop-slow-scripts'=>true]);

        $pdf->loadView('all_records');
        return $pdf->download('all_records.pdf');
    }
}
