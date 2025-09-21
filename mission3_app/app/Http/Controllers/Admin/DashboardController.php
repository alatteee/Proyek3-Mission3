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
        // jumlah mahasiswa per jurusan
        $majors = \App\Models\Student::select('major', \DB::raw('count(*) as total'))
            ->groupBy('major')
            ->get();

        $majorsData = $majors->pluck('total', 'major');
            
        // top 5 course paling banyak diambil
        $popularCourses = \App\Models\Course::withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();

        // distribusi nilai
        $grades = \DB::table('takes')
            ->select('letter', \DB::raw('count(*) as total'))
            ->whereNotNull('letter')
            ->groupBy('letter')
            ->get();

        return view('admin.dashboard.index', compact(
            'totalStudents',
            'totalCourses',
            'majors',
            'majorsData',     // <--- tambahin ini buat chart
            'popularCourses',
            'grades'
        ));
    }

}
