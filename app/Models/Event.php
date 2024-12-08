<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Add the fillable fields
    protected $fillable = [
        'title', 'date' , 'intakeid'
    ];

    // Optionally, you can cast the 'date' field to a date type
    protected $casts = [
        'date' => 'datetime',
    ];
}
