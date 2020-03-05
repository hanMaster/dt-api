<?php

namespace App\Http\Controllers;

use App\DayNight;
use App\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class DayNightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $day
     * @return Response
     */
    public function dayNightDay($day)
    {
        $day = Carbon::parse($day, Config::get('timezone'));
        $dayNight = DayNight::select('employee_id')->where('day', $day)->get();
        $result = [];
        $i = 0;
        foreach ($dayNight as $dn) {
            $result[$i]["employee_id"] = $dn->employee_id;
            $result[$i]["name"] = $dn->employee->name;
            $i++;
        }
        $response = new Response();
        $response->setContent($result);
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $day = new DayNight();
        $day->employee_id = $request->employee_id;
        $day->day = Carbon::parse($request->day, Config::get('timezone'));
        $rate = Rate::where('title', 'dayNight')->first();
        $day->profit = $rate->value;
        $day->save();
        $name = $day->employee->name;
        $newRecord = '{"employee_id":' . $day->employee_id . ', "name": "' . $name . '"}';
        $response = new Response();
        $response->setContent($newRecord);
        return $response;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $day
     * @param $emp_id
     * @return Response
     */
    public function destroy($day, $emp_id)
    {
        $response = new Response();
        try {
            $day = Carbon::parse($day, Config::get('timezone'));
            DayNight::where('day', $day)
                ->where('employee_id', $emp_id)
                ->delete();
        } catch (\Exception $e) {
            $response->setStatusCode(404);
            return $response;
        }
        $response->setStatusCode(200);
        return $response;
    }
}
