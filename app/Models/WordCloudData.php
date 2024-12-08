<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordCloudData extends Model
{
    use HasFactory;

    protected $fillable = ['word', 'value'];
}

