<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ganti kolom name -> full_name
            if (Schema::hasColumn('users', 'name')) {
                $table->renameColumn('name', 'full_name');
            }

            // tambah username unik (kalau belum ada)
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->unique()->after('id');
            }

            // role: admin / student (default student)
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin','student'])->default('student')->after('password');
            }

            // opsional: aktif/non-aktif
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) $table->dropColumn('is_active');
            if (Schema::hasColumn('users', 'role')) $table->dropColumn('role');
            if (Schema::hasColumn('users', 'username')) $table->dropColumn('username');
            if (Schema::hasColumn('users', 'full_name')) $table->renameColumn('full_name', 'name');
        });
    }
};
