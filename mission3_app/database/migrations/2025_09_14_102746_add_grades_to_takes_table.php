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
        Schema::table('takes', function (Blueprint $table) {
            $table->unsignedTinyInteger('score')->nullable()->after('enroll_date');
            $table->string('letter', 2)->nullable()->after('score');
            $table->decimal('grade_point', 3, 2)->nullable()->after('letter');
        });
    }

    public function down(): void
    {
        Schema::table('takes', function (Blueprint $table) {
            $table->dropColumn(['score', 'letter', 'grade_point']);
        });
    }

};
