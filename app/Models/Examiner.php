<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Extending Authenticatable for login
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // For API tokens if needed

class Examiner extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // Fillable fields that can be mass assigned
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_details',
        'cv_path',
        'registered_at',
        'registration_expires_at',
    ];
    

    // Hide sensitive fields (like password) from model's JSON representation
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Cast the date fields to Carbon instances
    protected $casts = [
        'registered_at' => 'datetime',
        'registration_expires_at' => 'datetime',
    ];

    // Many-to-Many relationship with Thesis
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'examiner_document', 'examiner_id', 'document_id');
    }
    

    public $timestamps = true;
}
