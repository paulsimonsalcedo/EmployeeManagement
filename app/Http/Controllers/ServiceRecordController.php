<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveServiceRecordRequest;
use App\Http\Requests\UpdateServiceRecordRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\ServiceRecord;
use App\Services\ServiceRecordService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $serviceRecord;

    public function __construct(ServiceRecordService $serviceRecord)
    {
        $this->serviceRecord = $serviceRecord;
    }

    public function index(Request $request)
    {
        $serviceRecords = ServiceRecord::with(['employee', 'department'])
        ->where('employee_id', $request->query('id')) // Use the `id` query parameter
        ->get();

        $departments = Department::all();

        return Inertia::render('ServiceRecord', [
            'serviceRecords' => $serviceRecords,
            'departments' => $departments,
            'employeeID' => $request->query('id'), // Pass `employeeID` to the view
        ]);
    }

    public function store(SaveServiceRecordRequest $request, $id)
    {
        if (!is_numeric($id)) {
            abort(400, 'Invalid Employee ID');
        }
    
        $validated = $request->validated();
    
        ServiceRecord::create([
            'employee_id' => (int)$id,
            'department_id' => $validated['department_id'],
            'role' => $validated['role'],
            'performance_notes' => $validated['performance_notes'],
        ]);
    }

    public function update(UpdateServiceRecordRequest $request, $id)
    {
        $validated = $request->validated();
        $update = ServiceRecord::find($id);
    
        if ($update) {
            $update->update([
                'employee_id' => $validated['employee_id'],
                'department_id' => $validated['department_id'],
                'role' => $validated['role'],
                'performance_notes' => $validated['performance_notes'],
            ]);
        }
    
        return false;
    }

    public function destroy($id)
    {
        $delete = ServiceRecord::findOrFail($id);
        $delete->delete();
    }

    public function allRecord()
    {
        $allService = ServiceRecord::with(['employee','department'])->get();
        return Inertia::render('AllRecord', ['allService' => $allService]);
    }
}
