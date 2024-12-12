<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService{

    public function saveEmployee($data)
    {
        if(isset($data)){
           return Employee::create($data);
        }
        return false;
    }

    public function updateEmployee(array $data, $id)
    {
        $employee = Employee::findOrFail($id);

        if($employee){
            $employee->update($data);
        }
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        if($employee){
            return $employee->delete();
        }
    }
}