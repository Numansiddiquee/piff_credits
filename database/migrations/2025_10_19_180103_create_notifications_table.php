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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_id'); // Who will receive this notification
            $table->unsignedBigInteger('sender_id')->nullable(); // Who triggered this notification (freelancer or client)
            $table->string('type')->nullable(); 
            $table->string('title')->nullable(); 
            $table->text('message')->nullable(); 
            $table->string('url')->nullable(); 
            $table->boolean('is_read')->default(false); 
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
