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
        Schema::table('classes', function (Blueprint $table) {
        $table->string('session_year', 9)->after('section');
        $table->unique(['school_id', 'name', 'section', 'session_year']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
        $table->dropUnique(['school_id', 'name', 'section', 'session_year']);
        $table->dropColumn('session_year');
    });
}
};
