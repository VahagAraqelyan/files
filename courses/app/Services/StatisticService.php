<?php

use App\Statistic;
use App\Statistic_count;
use App\Enable_work;

class StatisticService
{

    public static function insert_statistic($server)
    {

        if (empty($server)) {

            return false;
        }

        $user_ip = $server['REMOTE_ADDR'];

        $date_now = date("Y-m-d");

        $user_check = Statistic::select()->where('date', $date_now)->where('ip', $user_ip)->first();

        if (!empty($user_check)) {
            return false;
        }

        $insert_data1 = [
            'date' => $date_now,
            'ip' => $user_ip
        ];

        $date_count = Statistic_count::select()->where('date', $date_now)->first();

        if (!empty($date_count)) {

            Statistic_count::where('date', $date_now)
                ->update(['count' => $date_count['count'] + 1]);

        } else {
            $insert_data2 = [
                'count' => $date_count + 1,
                'date' => $date_now
            ];

            $res = Statistic_count::insert($insert_data2);
        }

        $date1 = date('Y-m-d H:i:s', strtotime("-1 month"));

        $result1 = Statistic::insert($insert_data1);
        Statistic::select()->where('date','<', $date1)->delete();
    }

    static function enable_working(){

        $enable_data = Enable_work::select()->first()->toArray();

        if($enable_data['enabling'] == 1){

            return 'enable_page';
        }

        return false;
    }
}
