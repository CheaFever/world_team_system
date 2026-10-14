<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_ID');
            $table->string('type_of_event', 150);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->date('event_date');
            $table->text('description')->nullable();
            
            // Foreign key referencing the users/admins table
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};