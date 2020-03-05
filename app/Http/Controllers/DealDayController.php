<?php

namespace App\Http\Controllers;

use App\DealDay;
use App\Employee;
use App\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class DealDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dealDay($day)
    {
        $day = Carbon::parse($day, Config::get('timezone'));
        $deals = DealDay::where('day', $day)->get();
        $employees = Employee::all();
        foreach ($deals as $deal) {
            $empl = $employees->find($deal->employee_id);
            $deal->name = $empl->name;
        }
        return $deals;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $day = new DealDay();
        $day->employee_id = $request->employee_id;
        $day->day = Carbon::parse($request->day, Config::get('timezone'));
        $day->dayOff = $request->dayOff;
        $day->leather = $request->leather;
        $day->wleather = $request->wleather;
        if (isset($request->fixPrice)) {
            $rate = Rate::where('title', 'deal')->first();
            $day->profit = round(($day->leather + $day->wleather) * $rate->value, 2);
        }
        $day->save();
        $response = new Response();
        $response->setContent($day);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\DealDay $dealDay
     * @return \Illuminate\Http\Response
     */
    public function show(DealDay $dealDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\DealDay $dealDay
     * @return \Illuminate\Http\Response
     */
    public function edit(DealDay $dealDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DealDay $dealDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DealDay $dealDay)
    {
        //
    }


    public function destroy(DealDay $dealDay)
    {
        $response = new Response();
        try {
            $dealDay->delete();
        } catch (\Exception $e) {
            $response->setStatusCode(404);
            return $response;
        }
        $response->setStatusCode(200);
        return $response;
    }
}
