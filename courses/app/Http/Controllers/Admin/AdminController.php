<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Statistic;
use App\Statistic_count;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Enable_work;

class AdminController extends Controller
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

        return view('admin/login');
    }

    public function dashboard()
    {

        return view('admin/dashboard/main');
    }

    public function ax_get_statistic(Request $reques)
    {

        $statistic_data = $reques->mounth;

        if (empty($statistic_data)) {

            $statistic_data = date('Y-m');
        }

        $date_day_month = explode('-', $statistic_data);
        $visit_result = Statistic_count::whereMonth('date', $date_day_month[1])->whereYear('date', $date_day_month[0])->get()->toArray();
        $all_user = User::whereMonth('created_at', $date_day_month[1])->whereYear('created_at', $date_day_month[0])->get()->toArray();
        $free_user = User::whereMonth('created_at', $date_day_month[1])->whereYear('created_at', $date_day_month[0])->where('plan_id', 1)->get()->toArray();
        $premium_user = User::whereMonth('created_at', $date_day_month[1])->whereYear('created_at', $date_day_month[0])->where('plan_id', 2)->get()->toArray();

        $all_arr = [];
        $free_arr = [];
        $all_key_arr = [];
        $free_key_arr = [];
        $premium__key_arr = [];
        $premium_arr = [];
        $date_arr = [];
        $int_visit = [];
        $visit_arr = [];

        foreach ($visit_result as $item => $value) {

            $date = explode('-', $value['date']);
            $visit_arr[$date[2]] = $value['count'];
            $int_visit[] = $value['count'];
        }

        foreach ($all_user as $item => $value) {

            $key = explode(' ', $value['created_at'])[0];
            $key = intval(explode('-', $key)[2]);

            if (array_key_exists($key, $all_arr)) {

                $num = $all_arr[$key];
                $all_arr[$key] = $num + 1;

            } else {
                $all_key_arr[] = $key;
                $all_arr[$key] = 1;
            }
        }

        foreach ($free_user as $item => $value) {

            $key = explode(' ', $value['created_at'])[0];
            $key = intval(explode('-', $key)[2]);

            if (array_key_exists($key, $free_arr)) {
                $num = $free_arr[$key];
                $free_arr[$key] = $num + 1;

            } else {
                $free_key_arr[] = $key;
                $free_arr[$key] = 1;
            }
        }

        foreach ($premium_user as $item => $value) {

            $key = explode(' ', $value['created_at'])[0];
            $key = intval(explode('-', $key)[2]);

            if (array_key_exists($key, $premium_arr)) {
                $num = $premium_arr[$key];

                $premium_arr[$key] = $num + 1;

            } else {
                $premium__key_arr[] = $key;
                $premium_arr[$key] = 1;
            }
        }

        $data['all_key_arr'] = $all_key_arr;
        $data['all_arr'] = $all_arr;

        $data['free_key_arr'] = $free_key_arr;
        $data['free_arr'] = $free_arr;

        $data['premium__key_arr'] = $premium__key_arr;
        $data['premium_arr'] = $premium_arr;

        $data['int_visit'] = $int_visit;
        $visit_arr = array_unique(array_merge($visit_arr, $all_key_arr, $free_key_arr, $premium__key_arr));
        $date_arr = array_sort($visit_arr);
        $data['date_arr'] = $date_arr;
        return view('admin/dashboard/statistic_answer', $data);
    }

    public function enable_work(){

        $data['enable_disable'] = Enable_work::select()->first()->toArray();
        return view('admin/dashboard/enable_work',$data);
    }

    public function ax_update_enable(Request $reques){

        $enabling = $reques->enabling;

        return Enable_work::where('id',1)
            ->update(['enabling' => $enabling]);
    }

}
