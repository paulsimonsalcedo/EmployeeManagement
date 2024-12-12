<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name','email','phone','hire_date','salary'];

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }
}
