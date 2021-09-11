<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::query()->paginate());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return EmployeeResource;
     */
    public function delete(Employee $employee)
    {
        $employee->delete();

        return new EmployeeResource($employee);
    }
}
