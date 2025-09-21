<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;

class StudentController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $q = $request->q;
        $students = Student::with('user')
            ->when($q, function($query) use ($q) {
                $query->whereHas('user', function($uq) use ($q){
                    $uq->where('username','like',"%$q%")
                    ->orWhere('full_name','like',"%$q%");
                })->orWhere('nim','like',"%$q%");
            })
            ->orderBy('nim')
            ->paginate(10)
            ->withQueryString();

        // bikin array of objects untuk JS
        $studentsData = $students->map(function($s){
            return [
                'id'    => $s->student_id,
                'name'  => $s->full_name,
                'nim'   => $s->nim,
                'major' => $s->major,
            ];
        });

        return view('admin.students.index', compact('students','q','studentsData'));
    }

    // FORM CREATE
    public function create()
    {
        return view('admin.students.create');
    }

    // STORE (buat user + student sekaligus)
    public function store(Request $request)
    {
        $data = $request->validate([
            // user
            'username'   => ['required','max:50','unique:users,username'],
            'full_name'  => ['required','max:255'],
            'email'      => ['nullable','email','max:255','unique:users,email'],
            'password'   => ['required','min:6'],

            // student
            'entry_year' => ['required','digits:4','integer','min:2000','max:'.date('Y')],
            'nim'        => ['required','max:20','unique:students,nim'],
            'major'      => ['nullable','max:100'],
            'phone'      => ['nullable','max:20'],
            'address'    => ['nullable'],
        ]);

        // 1) user
        $user = User::create([
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'] ?? null,
            'password'  => Hash::make($data['password']),
            'role'      => 'student',
            'is_active' => true,
        ]);

        // 2) student
        Student::create([
            'student_id' => $user->id,
            'entry_year' => $data['entry_year'],
            'nim'        => $data['nim'],
            'major'      => $data['major'] ?? null,
            'phone'      => $data['phone'] ?? null,
            'address'    => $data['address'] ?? null,
        ]);

        return redirect()->route('admin.students.index')->with('ok','Student created');
    }

    // EDIT
    public function edit(Student $student)
    {
        $student->load('user');
        return view('admin.students.edit', compact('student'));
    }

    // UPDATE (update user+student)
    public function update(Request $request, Student $student)
    {
        $user = $student->user;

        $data = $request->validate([
            'username'   => ['required','max:50','unique:users,username,'.$user->id],
            'full_name'  => ['required','max:255'],
            'email'      => ['nullable','email','max:255','unique:users,email,'.$user->id],
            'password'   => ['nullable','min:6'],

            'entry_year' => ['required','digits:4','integer','min:2000','max:'.date('Y')],
            'nim'        => ['required','max:20','unique:students,nim,'.$student->student_id.',student_id'],
            'major'      => ['nullable','max:100'],
            'phone'      => ['nullable','max:20'],
            'address'    => ['nullable'],
        ]);

        $user->update([
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'] ?? null,
            // update password kalau diisi
            'password'  => $data['password'] ? Hash::make($data['password']) : $user->password,
        ]);

        $student->update([
            'entry_year' => $data['entry_year'],
            'nim'        => $data['nim'],
            'major'      => $data['major'] ?? null,
            'phone'      => $data['phone'] ?? null,
            'address'    => $data['address'] ?? null,
        ]);

        return redirect()->route('admin.students.index')->with('ok','Student updated');
    }

    // DELETE (hapus user → student ikut terhapus via FK cascade)
    public function destroy(Student $student)
    {
        $student->user()->delete();
        return redirect()->route('admin.students.index')->with('ok','Student deleted');
    }

    public function show(\App\Models\Student $student)
    {
        $student->load('user');

        $courses = $student->courses()
            ->orderBy('course_code')
            ->paginate(10)
            ->withQueryString();

        // daftar course yang BELUM diambil student (untuk dropdown quick enroll)
        $availableCourses = \App\Models\Course::whereDoesntHave('students', function ($q) use ($student) {
            $q->where('students.student_id', $student->student_id);
        })->orderBy('course_code')->get();

        return view('admin.students.show', compact('student', 'courses', 'availableCourses'));
    }


    public function enroll(\Illuminate\Http\Request $request, \App\Models\Student $student)
    {
        $data = $request->validate(['course_id' => ['required','exists:courses,id']]);
        $student->courses()->syncWithoutDetaching([$data['course_id'] => ['enroll_date' => now()]]);
        return back()->with('ok','Student enrolled to course.');
    }

    public function unenroll(\App\Models\Student $student, \App\Models\Course $course)
    {
        $student->courses()->detach($course->id);
        return back()->with('ok','Student unenrolled from course.');
    }

    public function saveGrade(Request $request, Student $student, Course $course)
    {
        $data = $request->validate([
            'score'  => ['nullable','integer','between:0,100'],
            'letter' => ['nullable','in:A,AB,B,BC,C,D,E'], 
        ]);

        // hitung otomatis letter & point kalau admin isi score
        $letter = $data['letter'] ?? $this->letterFromScore($data['score']);
        $point  = $this->pointFromLetter($letter);

        $student->courses()->updateExistingPivot($course->id, [
            'score'       => $data['score'],
            'letter'      => $letter,
            'grade_point' => $point,
        ]);

        return back()->with('ok', 'Grade saved.');
    }

    private function letterFromScore(?int $s): ?string
    {
        if ($s === null) return null;
        return match (true) {
            $s >= 85 => 'A',
            $s >= 80 => 'AB',
            $s >= 75 => 'B',
            $s >= 70 => 'BC',
            $s >= 65 => 'C',
            $s >= 60 => 'D',
            default  => 'E',
        };
    }

    private function pointFromLetter(?string $L): ?float
    {
        return match ($L) {
            'A'  => 4.00,
            'AB' => 3.50,
            'B'  => 3.00,
            'BC' => 2.50,
            'C'  => 2.00,
            'D'  => 1.00,
            'E'  => 0.00,
            default => null,
        };
    }



}
