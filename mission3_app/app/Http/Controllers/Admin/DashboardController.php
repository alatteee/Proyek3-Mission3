<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = \App\Models\Student::count();
        $totalCourses  = \App\Models\Course::count();

        return view('admin.dashboard.index', compact('totalStudents', 'totalCourses'));
    }

}
