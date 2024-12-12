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
    public function store(SaveServiceRecordRequest $request, $id)
    {
        if (!is_numeric($id)) {
            abort(400, 'Invalid Employee ID');
        }
    
        $validated = $request->validated();
    
        $this->serviceRecord->saveService($validated, (int)$id);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRecord $serviceRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRecord $serviceRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRecordRequest $request, $id)
    {
        $validated = $request->validated();
        $this->serviceRecord->updateService($validated, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->serviceRecord->deleteService($id);
    }

    public function allRecord()
    {
        $allService = ServiceRecord::with(['employee','department'])->get();
        return Inertia::render('AllRecord', ['allService' => $allService]);
    }
}
