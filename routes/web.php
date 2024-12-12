<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceRecordController;
use App\Models\Department;
use App\Models\ServiceRecord;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'index')->name('employee');
    Route::post('/login','login')->name('login.post');
});

Route::middleware(['web','auth'])->group(function (){
    Route::get('/welcome', [EmployeeController::class, 'index'])->name('welcome');
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

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
