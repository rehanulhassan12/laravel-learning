<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
    Schema::create('timetables', function (Blueprint $table) {
    $table->id();
    $table->foreignId('class_id')->constrained()->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
    $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
    $table->foreignId('period_id')->constrained()->cascadeOnDelete();
     $table->enum('day', [
        'monday','tuesday','wednesday','thursday','friday','saturday'
    ]);
    $table->timestamps();
    $table->unique(['teacher_id', 'day', 'period_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
