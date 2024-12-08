<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'chapters', // Include this
        'final_submission_deadline',
        'presentation_date',
        'status',
    ];

    // Automatically cast chapters JSON to an array
    protected $casts = [
        'chapters' => 'array',
        'final_submission_deadline' => 'datetime',
        'presentation_date' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'intake_user');
    }
}
