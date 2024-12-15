<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::all();

        return Inertia::render('Department', ['departments' => $departments]);
    }

    public function store(SaveDepartmentRequest $request)
    {
        $data = $request->only('name','description');

        if(isset($data)){
            Department::create($data);
        }

        return false;
  
    }

    public function update(SaveDepartmentRequest $request, $id)
    {
        $validated = $request->validated();

        $department = Department::findOrFail($id);

        if($department){
            $department->update($validated);
        }

        return false;
    }


    public function destroy(Department $department)
    {
        $department->delete();
    }
}
