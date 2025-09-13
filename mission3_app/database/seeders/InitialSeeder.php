<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'full_name' => 'Administrator',
                'email'     => 'admin@example.com',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
            ]
        );

        // Student user
        $student = User::updateOrCreate(
            ['username' => 'sarah'],
            [
                'full_name' => 'Sarah Putri',
                'email'     => 'sarah@example.com',
                'password'  => Hash::make('sarah123'),
                'role'      => 'student',
            ]
        );

        // Insert student detail
        DB::table('students')->updateOrInsert(
            ['student_id' => $student->id],
            [
                'entry_year' => 2023,
                'nim'        => '231234567',
                'major'      => 'Informatika',
                'phone'      => '081234567890',
                'address'    => 'Jl. Melati No. 10',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Insert courses
        DB::table('courses')->insertOrIgnore([
            [
                'course_code' => 'IF101',
                'course_name' => 'Pemrograman Dasar',
                'credits'     => 3,
                'semester'    => 'Ganjil',
                'description' => 'Belajar dasar algoritma & pemrograman.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'course_code' => 'IF202',
                'course_name' => 'Basis Data',
                'credits'     => 3,
                'semester'    => 'Genap',
                'description' => 'Konsep database relasional & SQL.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
