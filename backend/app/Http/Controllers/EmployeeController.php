<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::query()->paginate());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee $employee
     * @return \App\Http\Resources\EmployeeResource;
     */
    public function delete(Employee $employee)
    {
        $employee->delete();
        return new EmployeeResource($employee);

    }
}
