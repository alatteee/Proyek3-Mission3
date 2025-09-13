<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;   // <— penting
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // data student (boleh null kalau belum ada record di tabel students)
        $student = optional($user)->student;

        // hitungan untuk stat cards
        $totalCourses    = Course::count();
        $enrolledCount   = $student ? $student->courses()->count() : 0;
        $availableToTake = max(0, $totalCourses - $enrolledCount);

        return view('student.dashboard.index', [
            'user'            => $user,
            'student'         => $student,
            'totalCourses'    => $totalCourses,
            'enrolledCount'   => $enrolledCount,
            'availableToTake' => $availableToTake,
        ]);
    }
}

