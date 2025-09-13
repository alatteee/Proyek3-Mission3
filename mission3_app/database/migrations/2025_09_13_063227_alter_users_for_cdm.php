<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users','name')) $t->renameColumn('name','full_name');
            if (!Schema::hasColumn('users','username')) $t->string('username',50)->unique()->after('id');
            if (!Schema::hasColumn('users','role')) $t->enum('role',['admin','student'])->default('student')->after('password');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
