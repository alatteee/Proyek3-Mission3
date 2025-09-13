<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return view('admin.students.index', compact('students','q'));
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
        $student->load('user'); // kalau mau tampilkan info akun user
        return view('admin.students.show', compact('student'));
    }

}
