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
        Schema::create('kyb_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_id')->constrained('verification_requests')->onDelete('cascade');
            $table->enum('type', ['registration_certificate', 'tax_id', 'bank_statement']);
            $table->string('file_path');
            $table->string('sumsub_doc_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyb_documents');
    }
};
