<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $t) {
            $t->id();  // = course_id
            $t->string('course_code', 20)->unique();   // kode MK (misal IF101)
            $t->string('course_name', 120);            // nama mata kuliah
            $t->unsignedTinyInteger('credits');        // sks

            // kolom tambahan 
            $t->string('semester', 20)->nullable();    // misal: Genap/Ganjil
            $t->text('description')->nullable();       // deskripsi matkul

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
