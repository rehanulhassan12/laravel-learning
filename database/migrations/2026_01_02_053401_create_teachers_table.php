<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')
              ->nullable()
              ->constrained()
             ->cascadeOnDelete();
              $table->string('name');
             $table->string('phone')->nullable();
             $table->enum('gender', ['male', 'female']);
                 $table->string('specialization');
                  $table->date('dob')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
