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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // Link student to a dorm group (nullable so a student can be saved without a group)
            $table->foreignId('dorm_group_id')->nullable()->constrained('dorm_groups')->nullOnDelete();
            $table->string('student_ID')->unique(); // unique student ID
            $table->string('name_khmer');
            $table->string('name_english');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('place_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('full_time')->default(0);
            $table->integer('absent')->default(0);
            $table->integer('permission')->default(0);
            $table->string('email')->nullable()->unique();
            $table->string('family')->nullable();
            $table->boolean('have_sibling')->default(false);
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_job')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
