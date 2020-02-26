<?php

namespace App\Http\Controllers;

use App\DayNight;
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
        return $dayNight;
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
        $day->profit = $day->employee->salary;
        $day->save();
        $response = new Response();
        $response->setContent($day);
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
