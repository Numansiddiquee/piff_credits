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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('to_email');
            $table->string('cc_email')->nullable();
            $table->string('bcc_email')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->morphs('model'); // Stores model_type & model_id
            $table->string('source'); // Stores source like "Invoice", "Quote"
            $table->json('attachments')->nullable(); // Store attachment file paths
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
