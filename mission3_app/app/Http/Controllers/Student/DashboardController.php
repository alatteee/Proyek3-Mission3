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

        // GPA & total SKS
        $gpa = null;
        $totalSks = 0;
        if ($student) {
            $sum = DB::table('takes')
                ->join('courses', 'courses.id', '=', 'takes.course_id')
                ->where('takes.student_id', $student->student_id)
                ->selectRaw('SUM(takes.grade_point * courses.credits) AS wsum')
                ->selectRaw('SUM(CASE WHEN takes.grade_point IS NOT NULL THEN courses.credits ELSE 0 END) AS csum')
                ->selectRaw('SUM(courses.credits) AS total_sks')
                ->first();

            $gpa = ($sum && $sum->csum) ? round($sum->wsum / $sum->csum, 2) : null;
            $totalSks = $sum->total_sks ?? 0;
        }

        // Distribusi nilai per huruf (A, AB, B, dll)
        $studentGrades = $student
            ? DB::table('takes')
                ->where('student_id', $student->student_id)
                ->whereNotNull('letter')
                ->select('letter', DB::raw('count(*) as total'))
                ->groupBy('letter')
                ->pluck('total', 'letter')
            : collect();

        return view('student.dashboard.index', [
            'user'            => $user,
            'student'         => $student,
            'totalCourses'    => $totalCourses,
            'enrolledCount'   => $enrolledCount,
            'availableToTake' => $availableToTake,
            'gpa'             => $gpa,
            'totalSks'        => $totalSks,
            'studentGrades'   => $studentGrades,
        ]);
    }
}
