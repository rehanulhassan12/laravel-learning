<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('screens', function (Blueprint $table) {
          $table->string('route_name');
    $table->string('icon')->nullable();
    $table->foreignId('parent_id')
          ->nullable()
          ->constrained('screens')
          ->onDelete('cascade');
        });
    }


   public function down(): void
{
    Schema::table('screens', function (Blueprint $table) {
        $table->dropForeign(['parent_id']);
        $table->dropColumn(['route_name', 'icon', 'parent_id']);
    });
}
};
