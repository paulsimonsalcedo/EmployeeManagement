<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceRecordController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
    Route::post('/save-employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::put('/update-employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/delete-employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');

    Route::get('/department', [DepartmentController::class, 'index'])->name('department');
    Route::post('/save-department', [DepartmentController::class, 'store'])->name('department.store');
    Route::put('/update-department/{department}', [DepartmentController::class , 'update'])->name('department.update');
    Route::delete('/delete-department/{department}', [DepartmentController::class, 'destroy'])->name('department.delete');

    Route::get('/serviceRecord', [ServiceRecordController::class, 'index'])->name('serviceRecord');
    Route::post('/save-serviceRecords/{id}', [ServiceRecordController::class, 'store'])->name('record.store');
    Route::delete('/delete-service/{id}',[ServiceRecordController::class, 'destroy'])->name('service.delete');
    Route::put('/update-service-record/{id}', [ServiceRecordController::class, 'update'])->name('service.update');
    Route::get('/all-records', [ServiceRecordController::class, 'allRecord'])->name('all.records');

});