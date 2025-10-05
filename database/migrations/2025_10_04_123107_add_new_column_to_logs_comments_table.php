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
        Schema::table('logs_comments', function (Blueprint $table) {
            $table->string('action_from')->nullable()->after('action_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs_comments', function (Blueprint $table) {
            $table->dropColumn('action_from');
        });
    }
};
