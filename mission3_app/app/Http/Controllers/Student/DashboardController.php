<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $student = optional($user)->student;

        $totalCourses    = Course::count();
        $enrolledCount   = $student ? $student->courses()->count() : 0;
        $availableToTake = max(0, $totalCourses - $enrolledCount);

        // ⬇️ hitung GPA tanpa select kolom lain
        $sum = null;
        if ($student) {
            $sum = DB::table('takes')
                ->join('courses', 'courses.id', '=', 'takes.course_id')
                ->where('takes.student_id', $student->student_id)
                ->selectRaw('SUM(takes.grade_point * courses.credits) AS wsum')
                ->selectRaw('SUM(CASE WHEN takes.grade_point IS NOT NULL THEN courses.credits ELSE 0 END) AS csum')
                ->first();
        }

        $gpa = ($sum && $sum->csum) ? round($sum->wsum / $sum->csum, 2) : null;

        return view('student.dashboard.index', [
            'user'            => $user,
            'student'         => $student,
            'totalCourses'    => $totalCourses,
            'enrolledCount'   => $enrolledCount,
            'availableToTake' => $availableToTake,
            'gpa'             => $gpa,
        ]);
    }
}

