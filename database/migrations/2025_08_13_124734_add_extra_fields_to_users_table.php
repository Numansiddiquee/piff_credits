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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->string('plain_hash')->nullable()->after('password');
            $table->string('company_name')->nullable()->after('name');

            // If you want to enforce foreign key constraint
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->dropColumn('company_name');
            $table->dropColumn('plain_hash');
        });
    }

};
