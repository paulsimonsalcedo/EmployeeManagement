<?php

namespace App\Services;

use App\Models\Department;
use Inertia\Inertia;

class DepartmentService{

    public function saveDepartment($data)
    {
        if(isset($data)){
            return Department::create($data);
        }
        return response()->json(['message' => 'Cannot Save']);
    }

    public function updateDepartment($id, array $data)
    {
        $department = Department::findOrFail($id);
        return $department->update($data);
    }
    
}