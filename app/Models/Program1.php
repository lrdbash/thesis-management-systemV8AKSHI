<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'enrolled_students', 
        'passed_students', 
        'failed_students'
    ];
}

