<?php

namespace App\Http\Controllers;

use App\DealDay;
use App\FixedDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function reportByMonth($date)
    {
        $date = Carbon::parse($date, Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $endDay = $date->endOfMonth()->toDateString();

        $rows = DB::select(

            '     select employee_id, sum(profit) as amount, e.name from

            (SELECT employee_id, profit, day FROM deal_days
            WHERE day BETWEEN ? and ?
            UNION ALL
            SELECT employee_id, profit, day FROM fixed_days
            WHERE day BETWEEN ? and ?
            UNION ALL
            SELECT employee_id, profit, day FROM security_days
            WHERE day BETWEEN ? and ?
            ) x
            inner join employees e on e.id = employee_id
            GROUP BY employee_id'

            , [$startDay, $endDay, $startDay, $endDay, $startDay, $endDay]);
        return $rows;
    }


    public function dealReport($date)
    {
        $date = Carbon::parse($date, Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $endDay = $date->endOfMonth()->toDateString();

        $rows = DB::select(
            'select dd.employee_id as id, sum(dd.profit) as amount, e.name
            from deal_days as dd
            inner join employees as e on e.id = dd.employee_id
            WHERE day BETWEEN ? and ?
            GROUP BY dd.employee_id'
            , [$startDay, $endDay]);
        return $rows;
    }

    public function fixedReport($date)
    {
        $date = Carbon::parse($date, Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $endDay = $date->endOfMonth()->toDateString();

        $rows = DB::select(
            'select fd.employee_id as id, sum(fd.profit) as amount, e.name
            from fixed_days as fd
            inner join employees as e on e.id = fd.employee_id
            WHERE day BETWEEN ? and ?
            GROUP BY fd.employee_id'
            , [$startDay, $endDay]);
        return $rows;
    }

    public function securityReport($date)
    {
        $date = Carbon::parse($date, Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $endDay = $date->endOfMonth()->toDateString();

        $rows = DB::select(
            'select sd.employee_id as id, sum(sd.profit) as amount, e.name
            from security_days as sd
            inner join employees as e on e.id = sd.employee_id
            WHERE day BETWEEN ? and ?
            GROUP BY sd.employee_id'
            , [$startDay, $endDay]);
        return $rows;
    }


}
