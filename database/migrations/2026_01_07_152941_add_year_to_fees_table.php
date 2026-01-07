<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->year('year')->after('id'); // add year column
            $table->unique(['class_id', 'school_id', 'year']); // prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->dropUnique(['class_id','school_id','year']);
            $table->dropColumn('year');
        });
    }
};
