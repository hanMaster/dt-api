<?php

namespace App\Http\Controllers;

use App\Rate;
use App\SecurityDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class SecurityDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $day
     * @return Response
     */
    public function securityDay($day)
    {
        $day = Carbon::parse($day, Config::get('timezone'));
        $secure = SecurityDay::select('employee_id')->where('day', $day)->get();
        return $secure;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $day = new SecurityDay();
        $day->employee_id = $request->employee_id;
        $day->day = Carbon::parse($request->day, Config::get('timezone'));
        $rate = Rate::where('title', 'security')->first();
        $day->profit = $rate->value;
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
            SecurityDay::where('day', $day)
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
