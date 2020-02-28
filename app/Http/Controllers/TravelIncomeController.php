<?php

namespace App\Http\Controllers;

use App\TravelIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class TravelIncomeController extends Controller
{
    public function index($month){
        $date = Carbon::parse($month,Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $incomes = TravelIncome::where('day', $startDay)->get();
        foreach ($incomes as $income) {
            $income->name = $income->employee->name;
        }
        return $incomes;

    }

    public function create(Request $request)
    {
        $income = new TravelIncome();
        $income->employee_id = $request->employee_id;
        $income->income = $request->income;
        $date = Carbon::parse($request->day,Config::get('timezone'));
        $startDay = $date->startOfMonth()->toDateString();
        $income->day = $startDay;
        $income->save();
        return $income;
    }

    public function destroy(TravelIncome $income)
    {
        $response = new Response();
        try {
            $income->delete();
        } catch (\Exception $e) {
            $response->setStatusCode(404);
            return $response;
        }
        $response->setStatusCode(200);
        return $response;
    }
}
