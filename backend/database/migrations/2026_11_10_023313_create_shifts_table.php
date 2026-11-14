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
    Schema::create('shifts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
        $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
        $table->foreignId('shift_template_id')->nullable()->constrained()->nullOnDelete();
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->unsignedTinyInteger('duration_hours');
        $table->timestamps();

        $table->unique(['schedule_id', 'employee_id', 'date']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
