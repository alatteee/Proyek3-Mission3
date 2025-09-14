<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id';
    public $incrementing  = false;       // PK bukan auto-increment
    protected $keyType    = 'int';

    protected $fillable = [
        'student_id', 'entry_year', 'nim', 'major', 'phone', 'address'
    ];

     // ke user (users.id = students.student_id)
   public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id', 'id');
    }


    // relasi pivot ke courses via takes
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'takes', 'student_id', 'course_id')
            ->withPivot(['enroll_date', 'score', 'letter', 'grade_point'])
            ->withTimestamps();
    }

    protected $appends = ['full_name']; // agar ikut ter-serialize (opsional)


    public function getFullNameAttribute()
    {
        return $this->user->full_name ?? $this->user->username ?? null;
    }
}
