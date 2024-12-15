<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $employees = Employee::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->with(['serviceRecords' => function ($query) {
                $query->latest()->with('department'); // Eager load latest service record with department
            }])
            ->paginate(6)
            ->through(function ($employee) {

                $latestServiceRecord = $employee->serviceRecords->first(); 
                $employee->department = $latestServiceRecord ? $latestServiceRecord->department->name : 'N/A';
                return $employee;
            });
    
        return Inertia::render('Dashboard', [
            'employees' => $employees,
            'filters' => ['search' => $search],
        ]);
    }

    public function store(SaveEmployeeRequest $request)
    {
        $validated = $request->validated();

        if(isset($validated)){
            Employee::create($validated);
         }

        return false;
    }

    public function update(SaveEmployeeRequest $request, $id)
    {   
        $validated = $request->validated();

        $employee = Employee::findOrFail($id);

        if($employee){
            $employee->update($validated);
        }

        return false;
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        if($employee){
            $employee->delete();
        }
    }
}
