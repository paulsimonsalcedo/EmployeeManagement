<?php

namespace App\Services;

use App\Models\ServiceRecord;

class ServiceRecordService{

    public function saveService(array $data,  $employee_id)
    {
        return ServiceRecord::create([
            'employee_id' => $employee_id,
            'department_id' => $data['department_id'],
            'role' => $data['role'],
            'performance_notes' => $data['performance_notes'],
        ]);
    }

    public function deleteService($id)
    {
        $delete = ServiceRecord::findOrFail($id);

        return $delete->delete();
    }

    public function updateService(array $data, $id)
    {
        // Use the $id directly
        $update = ServiceRecord::find($id);
    
        if ($update) {
            $update->update([
                'employee_id' => $data['employee_id'],
                'department_id' => $data['department_id'],
                'role' => $data['role'],
                'performance_notes' => $data['performance_notes'],
            ]);
    
            return true;
        }
    
        return false;
    }
}