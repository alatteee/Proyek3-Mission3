<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $t) {
            $t->unsignedBigInteger('student_id')->primary(); // FK -> users.id
            $t->year('entry_year');

          
            $t->string('nim', 20)->unique();
            $t->string('major', 100)->nullable();   
            $t->string('phone', 20)->nullable();
            $t->text('address')->nullable();

            $t->timestamps();

            $t->foreign('student_id')
              ->references('id')->on('users')
              ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
