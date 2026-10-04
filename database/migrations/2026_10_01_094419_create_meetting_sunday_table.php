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
        Schema::create('meetting_sunday', function (Blueprint $table) {
            $table->id('meetting_id'); // Primary key
            $table->string('meetting_name'); // meetting_name
            $table->dateTime('start')->nullable(); // start datetime
            $table->dateTime('stop')->nullable(); // stop datetime
            $table->timestamp('create_at')->nullable(); // custom create_at field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetting_sunday');
    }
};