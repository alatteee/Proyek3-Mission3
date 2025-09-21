<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('course_code')->paginate(10);

        // siapkan array of objects untuk JS
        $coursesData = $courses->map(function($c){
            return [
                'id'    => $c->id,
                'code'  => $c->course_code,
                'name'  => $c->course_name,
                'sks'   => $c->credits,
                'sem'   => $c->semester,
            ];
        });

        return view('admin.courses.index', compact('courses','coursesData'));
    }


    // FORM CREATE
    public function create()
    {
        return view('admin.courses.create');
    }

    // SIMPAN
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => ['required','max:20','unique:courses,course_code'],
            'course_name' => ['required','max:120'],
            'credits'     => ['required','integer','min:0','max:30'],
            'semester'    => ['nullable','max:20'],
            'description' => ['nullable'],
        ]);

        Course::create($data);
        return redirect()->route('admin.courses.index')->with('ok','Course created');
    }

    // FORM EDIT
    public function edit(\App\Models\Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    // UPDATE
    public function update(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $data = $request->validate([
            'course_code' => ['required','max:20','unique:courses,course_code,'.$course->id],
            'course_name' => ['required','max:120'],
            'credits'     => ['required','integer','min:0','max:30'],
            'semester'    => ['nullable','max:20'],
            'description' => ['nullable'],
        ]);

        $course->update($data);
        return redirect()->route('admin.courses.index')->with('ok','Course updated');
    }

    // DELETE
    public function destroy(\App\Models\Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('ok','Course deleted');
    }

    public function show(Course $course)
    {
        // daftar student yg sudah ambil course ini
        $students = $course->students()
            ->with('user') // akses $s->user->full_name / email
            ->orderBy('student_id')         
            ->paginate(15)
            ->withQueryString();

        // daftar student yg BELUM ambil course ini
        $availableStudents = \App\Models\Student::with('user')
            ->whereDoesntHave('courses', function($q) use ($course) {
                $q->where('courses.id', $course->id);
            })
            ->orderBy('nim')
            ->get();

        return view('admin.courses.show', compact('course', 'students', 'availableStudents'));
    }

    public function bulkEnroll(Request $request, Course $course)
    {
        $data = $request->validate([
            'student_ids'   => ['required','array'],
            'student_ids.*' => ['exists:students,student_id'],
        ]);

        $enrollData = collect($data['student_ids'])->mapWithKeys(fn($id) => [
            $id => ['enroll_date' => now()]
        ]);

        $course->students()->syncWithoutDetaching($enrollData);

        return back()->with('ok', count($data['student_ids']).' students enrolled to '.$course->course_name.'.');
    }


    
}
