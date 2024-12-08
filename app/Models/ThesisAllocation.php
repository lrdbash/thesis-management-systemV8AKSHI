<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesisAllocation extends Model
{
    use HasFactory;

    protected $table = 'thesis_allocations'; // Specify the table name (optional if it's plural)

    protected $fillable = [
        'label', // For the label in the treemap
        'parent', // For the parent label (hierarchy)
        'value', // The allocated value
    ];

    // Define any relationships or additional methods here
}

