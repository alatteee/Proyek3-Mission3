<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'credits',
        'semester',
        'description',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'takes', 'course_id', 'student_id')
            ->withPivot(['enroll_date', 'score', 'letter', 'grade_point'])
            ->withTimestamps();
    }

}
