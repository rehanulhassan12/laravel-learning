<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->cascadeOnDelete();

            $table->decimal('yearly_amount', 10, 2);
            $table->decimal('monthly_amount', 10, 2);

            $table->timestamps();

            $table->unique(['school_id', 'class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
