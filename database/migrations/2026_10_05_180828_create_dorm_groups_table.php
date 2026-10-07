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
        Schema::create('dorm_groups', function (Blueprint $table) {
            $table->id(); // group_id
            $table->string('group_name');
            $table->text('description')->nullable();
            $table->string('room_number')->nullable();
            $table->unsignedInteger('maximum_capacity')->default(35); // capacity limit (rule: up to 35)
            $table->unsignedInteger('current_number_of_students')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dorm_groups');
    }
};
