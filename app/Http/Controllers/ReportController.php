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

        return DB::select(

            'SELECT employees.name, COALESCE(deal,0) as deal , COALESCE(dayNight,0) as dayNight, COALESCE(fix,0) as fix,COALESCE(travel,0) as travel, COALESCE(secur,0) as secur, ( COALESCE(deal,0) + COALESCE(dayNight,0) + COALESCE(fix,0) + COALESCE(travel,0) + COALESCE(secur,0)) AS total
FROM
(SELECT employee_id as id, sum(deal_days.profit) as deal
FROM deal_days
WHERE (day BETWEEN ? and ?)
GROUP BY employee_id) as deal_res
RIGHT JOIN employees ON deal_res.id = employees.id

LEFT JOIN
(SELECT employee_id as id, sum(day_nights.profit) as dayNight
FROM day_nights
WHERE (day BETWEEN ? and ?)
GROUP BY employee_id) as dn ON employees.id = dn.id

LEFT JOIN
(SELECT employee_id as id, sum(fixed_days.profit) as fix
FROM fixed_days
WHERE (day BETWEEN ? and ?)
GROUP BY employee_id) as fd ON employees.id = fd.id

LEFT JOIN
(SELECT employee_id as id, sum(travel_incomes.income) as travel
FROM travel_incomes
WHERE (day BETWEEN ? and ?)
GROUP BY employee_id) as ti ON employees.id = ti.id

LEFT JOIN
(SELECT employee_id as id, sum(security_days.profit) as secur
FROM security_days
WHERE (day BETWEEN ? and ?)
GROUP BY employee_id) as sd ON employees.id = sd.id

ORDER BY name'

            , [$startDay, $endDay, $startDay, $endDay, $startDay, $endDay, $startDay, $endDay, $startDay, $endDay]);
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

        return DB::select(
            'select fd.employee_id as id, sum(fd.profit) as amount, e.name
            from fixed_days as fd
            inner join employees as e on e.id = fd.employee_id
            WHERE day BETWEEN ? and ?
            GROUP BY fd.employee_id'
            , [$startDay, $endDay]);
    }

    public function securityReport($date)
    {
        $date = Carbon::parse($date, Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $endDay = $date->endOfMonth()->toDateString();

        return DB::select(
            'select sd.employee_id as id, sum(sd.profit) as amount, e.name
            from security_days as sd
            inner join employees as e on e.id = sd.employee_id
            WHERE day BETWEEN ? and ?
            GROUP BY sd.employee_id'
            , [$startDay, $endDay]);
    }

    public function dayNightReport($date)
    {
        $date = Carbon::parse($date, Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $endDay = $date->endOfMonth()->toDateString();

        return DB::select(
            'select dn.employee_id as id, sum(dn.profit) as amount, e.name
            from day_nights as dn
            inner join employees as e on e.id = dn.employee_id
            WHERE day BETWEEN ? and ?
            GROUP BY dn.employee_id'
            , [$startDay, $endDay]);
    }
}


/**
 * SELECT employees.name, COALESCE(deal,0) as deal , COALESCE(dayNight,0) as dayNight, COALESCE(fix,0) as fix,COALESCE(travel,0) as travel, COALESCE(secur,0) as secur, ( COALESCE(deal,0) + COALESCE(dayNight,0) + COALESCE(fix,0) + COALESCE(travel,0) + COALESCE(secur,0)) AS total
 * FROM
 * (SELECT employee_id as id, sum(deal_days.profit) as deal
 * FROM deal_days
 * WHERE (day BETWEEN '2020-03-01' and '2020-03-31')
 * GROUP BY employee_id) as deal_res
 * RIGHT JOIN employees ON deal_res.id = employees.id
 *
 * LEFT JOIN
 * (SELECT employee_id as id, sum(day_nights.profit) as dayNight
 * FROM day_nights
 * WHERE (day BETWEEN '2020-03-01' and '2020-03-31')
 * GROUP BY employee_id) as dn ON employees.id = dn.id
 *
 * LEFT JOIN
 * (SELECT employee_id as id, sum(fixed_days.profit) as fix
 * FROM fixed_days
 * WHERE (day BETWEEN '2020-03-01' and '2020-03-31')
 * GROUP BY employee_id) as fd ON employees.id = fd.id
 *
 * LEFT JOIN
 * (SELECT employee_id as id, sum(travel_incomes.income) as travel
 * FROM travel_incomes
 * WHERE (day BETWEEN '2020-03-01' and '2020-03-31')
 * GROUP BY employee_id) as ti ON employees.id = ti.id
 *
 * LEFT JOIN
 * (SELECT employee_id as id, sum(security_days.profit) as secur
 * FROM security_days
 * WHERE (day BETWEEN '2020-03-01' and '2020-03-31')
 * GROUP BY employee_id) as sd ON employees.id = sd.id
 *
 * ORDER BY name
 *
 *
 *
 *
 *
 */
