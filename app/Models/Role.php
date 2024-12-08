<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Define the relationship with the User model.
     * A role can belong to many users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
