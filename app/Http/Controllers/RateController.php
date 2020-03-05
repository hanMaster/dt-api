<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RateController extends Controller
{
    public function index(){
        return Rate::select('title', 'value')->get();
    }

    public function store(Request $request){
        $rate = Rate::where('title', $request[0]['title'])->first();
        $rate->value = $request[0]['value'];
        $rate->save();
        $rate = Rate::where('title', $request[1]['title'])->first();
        $rate->value = $request[1]['value'];
        $rate->save();
        $rate = Rate::where('title', $request[2]['title'])->first();
        $rate->value = $request[2]['value'];
        $rate->save();
        $rate = Rate::where('title', $request[3]['title'])->first();
        $rate->value = $request[3]['value'];
        $rate->save();

        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }
}
