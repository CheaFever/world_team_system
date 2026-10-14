<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');       // ឧ. "សិស្សថ្មីត្រូវបានបញ្ចូល"
            $table->text('message');       // ឧ. "សិស្សឈ្មោះ សុខ ចាន់ ត្រូវបានចុះឈ្មោះ"
            $table->string('type');        // created, updated, deleted
            $table->boolean('is_read')->default(false); // false = មិនទាន់អាន, true = អានរួច
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};