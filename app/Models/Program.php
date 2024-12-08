<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    // Define the table name (if it's different from the default plural form of the model name)
    protected $table = 'programs';

    // Define the fillable fields (the columns that can be mass-assigned)
    protected $fillable = [
        'name', 
        'students_count',
        'enrolled_students',
        'thesis_topics',
        'approved_theses',
        'disapproved_theses',
        'examiner_duration_0_2',
        'examiner_duration_2_5',
        'examiner_duration_5_10',
        'examiner_duration_10_plus',
        'average_response_time'
    ];
}

