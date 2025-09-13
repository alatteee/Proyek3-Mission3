<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('takes', function (Blueprint $t) {
            $t->unsignedBigInteger('student_id');
            $t->unsignedBigInteger('course_id');

            $t->date('enroll_date')->useCurrent(); // default = hari ini

            $t->timestamps();

            // primary key gabungan
            $t->primary(['student_id', 'course_id']);

            // foreign key
            $t->foreign('student_id')
              ->references('student_id')->on('students')
              ->cascadeOnDelete();

            $t->foreign('course_id')
              ->references('id')->on('courses')
              ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('takes');
    }
};
