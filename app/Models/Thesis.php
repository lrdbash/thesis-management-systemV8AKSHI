<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'approved'];

    // Many-to-Many relationship with Examiner
    public function examiners()
    {
        return $this->belongsToMany(Examiner::class, 'examiner_thesis');
    }

     // Retrieve all approved theses
//$approvedTheses = Thesis::where('approved', true)->get();
}
