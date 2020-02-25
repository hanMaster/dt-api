<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/employees', 'EmployeeController@employees');
Route::post('/employees', 'EmployeeController@store');
Route::patch('/employees/{employee}', 'EmployeeController@update');
Route::get('/employees/deal', 'EmployeeController@deal');
Route::get('/employees/fixed', 'EmployeeController@fixed');
Route::get('/employees/dayNight', 'EmployeeController@dayNight');
Route::get('/employees/security', 'EmployeeController@security');

Route::get('/deal/{day}', 'DealDayController@dealDay');
Route::get('/fixed/{day}', 'FixedDayController@fixedDay');
Route::get('/security/{day}', 'SecurityDayController@securityDay');

Route::post('/deal', 'DealDayController@create');
Route::post('/fixed', 'FixedDayController@create');
Route::post('/security', 'SecurityDayController@create');

Route::delete('/deal/{dealDay}', 'DealDayController@destroy');
Route::delete('/fixed/{fixedDay}', 'FixedDayController@destroy');
Route::delete('/security/{day}/{emp_id}', 'SecurityDayController@destroy');

Route::get('/report/{date}', 'ReportController@reportByMonth');
Route::get('/reports/deal/{date}', 'ReportController@dealReport');
Route::get('/reports/fixed/{date}', 'ReportController@fixedReport');
Route::get('/reports/security/{date}', 'ReportController@securityReport');
