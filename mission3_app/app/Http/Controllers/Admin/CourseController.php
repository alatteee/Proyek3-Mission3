<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // LIST
    public function index()
    {
        $courses = Course::orderBy('course_code')->paginate(10);
        return view('admin.courses.index', compact('courses'));
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
        // paginate di relasi many-to-many + bawa relasi user agar bisa tampilkan nama
        $students = $course->students()
            ->with('user')          // akses $s->user->full_name / email
            ->orderBy('student_id')         
            ->paginate(15)
            ->withQueryString();

        return view('admin.courses.show', compact('course', 'students'));
    }

    
}
