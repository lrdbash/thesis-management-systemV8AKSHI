<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Ensure role is mass assignable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }

    /**
     * Check if the user is a staff member.
     *
     * @return bool
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Relationship with intakes - many-to-many relationship.
     * Assumes `intake_user` as the pivot table.
     */
    public function intakes()
    {
        return $this->belongsToMany(Intake::class, 'intake_user');
    }

    /**
     * Relationship for assigned supervisors (students to supervisors).
     */
    public function assignedSupervisors()
    {
        return $this->belongsToMany(User::class, 'supervisor_student', 'student_id', 'supervisor_id');
    }

    /**
     * Relationship for supervised students (supervisors to students).
     */
    public function supervisedStudents()
    {
        return $this->belongsToMany(User::class, 'supervisor_student', 'supervisor_id', 'student_id');
    }

    public function documents()
{
    return $this->hasMany(Document::class, 'user_id');
}

}
