<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // daftar semua course + info sudah di-enroll/belum
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $courses = Course::query()
            ->when($q, fn($qr) => $qr->where(function($s) use ($q) {
                $s->where('course_code','like',"%$q%")
                ->orWhere('course_name','like',"%$q%");
            }))
            ->orderBy('course_code')
            ->paginate(10)
            ->withQueryString();

        $student = $request->user()->student;

        // id course yang SUDAH di-enroll student (untuk badge "Enrolled")
        $enrolledIds = $student?->courses()->pluck('courses.id')->toArray() ?? [];

        // map: course_id => model (punya pivot letter/score/grade_point)
        $my = $student
            ? $student->courses()
                ->select('courses.id')
                ->withPivot(['letter','score','grade_point'])
                ->get()
                ->keyBy('id')
            : collect();

        return view('student.courses.index', compact('courses','q','my','enrolledIds'));
    }



    // daftar course yang sudah diambil
    public function mine(Request $request)
    {
        $student = $request->user()->student;
        $courses = $student->courses()->orderBy('course_code')->paginate(10);

        return view('student.courses.mine', compact('courses'));
    }

    // enroll (attach ke pivot takes)
    public function enroll(Request $request, Course $course)
    {
        $student = $request->user()->student;

        // kalau belum punya row di students, amankan
        abort_unless($student, 403, 'Student profile not found.');

        // cegah double-enroll
        if ($student->courses()->where('courses.id', $course->id)->exists()) {
            return back()->with('ok', 'Kamu sudah mengambil course ini.');
        }

        $student->courses()->attach($course->id, [
            'enroll_date' => now()->toDateString(),
        ]);

        return back()->with('ok', 'Enroll berhasil!');
    }

    // drop dari course yang sudah diambil
    public function drop(Request $request, Course $course)
    {
        $student = $request->user()->student;
        abort_unless($student, 403);

        $student->courses()->detach($course->id);

        return back()->with('ok', 'Course berhasil di-drop.');
    }
}
