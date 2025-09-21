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

        $student = $request->user()->student;

        return view('student.courses.index', [
            'courses'     => $courses,
            'q'           => $q,
            'my'          => $my,
            'enrolledIds' => $enrolledIds,
            'studentData' => [
                'id'    => $student->student_id,
                'name'  => $student->full_name,
                'nim'   => $student->nim,
                'major' => $student->major,
            ],
            'coursesData' => $courses->map(function($c){
                return [
                    'id'    => $c->id,
                    'code'  => $c->course_code,
                    'name'  => $c->course_name,
                    'sks'   => $c->credits,
                    'sem'   => $c->semester,
                ];
            })
        ]);

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
    
    public function bulkEnroll(Request $request)
    {
        $student = $request->user()->student;

        // pastikan student ada
        abort_unless($student, 403);

        $data = $request->validate([
            'course_ids'   => ['required','array'],
            'course_ids.*' => ['exists:courses,id'],
        ]);

        // map course_id => data pivot (enroll_date)
        $enrollData = collect($data['course_ids'])->mapWithKeys(function($id){
            return [$id => ['enroll_date' => now()]];
        });

        // enroll semua course yang dipilih
        $student->courses()->syncWithoutDetaching($enrollData);

        return redirect()
            ->route('student.courses.index')
            ->with('ok', 'Berhasil enroll '.count($data['course_ids']).' course.');
    }


}
