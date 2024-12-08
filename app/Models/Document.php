<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'status',
        'phase',
        'comment' // Add 'comment' here
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function examiners()
{
    return $this->belongsToMany(Examiner::class, 'examiner_document', 'document_id', 'examiner_id');
}

}
