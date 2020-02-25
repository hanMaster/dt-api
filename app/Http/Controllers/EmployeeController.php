<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function employees()
    {
        return Employee::all();
    }

    public function deal()
    {
        return Employee::where('type', 'deal')->get();
    }

    public function fixed()
    {
        return Employee::where('type', 'fixed')->get();
    }

    public function dayNight()
    {
        return Employee::where('type', 'dayNight')->get();
    }

    public function security()
    {
        return Employee::where('type', 'security')->get();
    }


    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'salary' => 'numeric'
        ]);
        $employee = Employee::create(['name' => $request->name, 'type' => $request->type]);
        if (isset($request->salary)){
            $employee->salary = $request->salary;
            $employee->save();
        }

        return $employee;

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'min:2',
            'salary' => 'numeric'
        ]);

        $employee->name = $request->name;
        $employee->type = $request->type;
        $employee->salary = $request->salary;
        $employee->save();

        $response = new Response();
        $response->setContent($employee);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
