<?php

namespace App\Http\Controllers;

use App\Employee;
use App\FixedDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class FixedDayController extends Controller
{
    public function fixedDay($day)
    {
        $day = Carbon::parse($day,Config::get('timezone'));
        $fixes = FixedDay::where('day', $day)->get();
        foreach ($fixes as $fix) {
            $fix->name = $fix->employee->name;
        }
        return $fixes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $employees = Employee::all();
        $employee = $employees->find($request->employee_id);
        $salary = $employee->salary;

        $rate = $salary / ($request->countDaysInMonth - $request->countDaysOff) /8;
        $day = new FixedDay();
        $day->employee_id = $request->employee_id;
        $day->day = Carbon::parse($request->day, Config::get('timezone'));
        $day->dayOff = $request->dayOff;
        $day->hours = $request->hours;
        $day->profit = round($request->hours * $rate, 2);
        $day->save();
        $response = new Response();
        $response->setContent($day);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FixedDay  $fixedDay
     * @return \Illuminate\Http\Response
     */
    public function show(FixedDay $fixedDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FixedDay  $fixedDay
     * @return \Illuminate\Http\Response
     */
    public function edit(FixedDay $fixedDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FixedDay  $fixedDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FixedDay $fixedDay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FixedDay  $fixedDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixedDay $fixedDay)
    {
        $response = new Response();
        try {
            $fixedDay->delete();
        } catch (\Exception $e) {
            $response->setStatusCode(404);
            return $response;
        }
        $response->setStatusCode(200);
        return $response;
    }
}
