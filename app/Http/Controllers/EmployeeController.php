<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $employees = Employee::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(6);
    
        return Inertia::render('Welcome', [
            'employees' => $employees,
            'filters' => ['search' => $search], // Ensure filters are always included
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveEmployeeRequest $request)
    {
        $validated = $request->validated();
        $this->employeeService->saveEmployee($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveEmployeeRequest $request, $id)
    {   
        $validated = $request->validated();
        $this->employeeService->updateEmployee($validated, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->employeeService->deleteEmployee($id);
    }
}
