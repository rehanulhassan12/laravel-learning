<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('roll_no');
            $table->enum('gender', ['male', 'female']);
            $table->date('dob');

            $table->foreignId('guardian_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['class_id', 'roll_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
