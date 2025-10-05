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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id', 255)->nullable()->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('payment_delay_note')->nullable();
            $table->string('terms')->nullable();
            $table->string('status')->nullable();
            $table->string('terms_condition')->nullable();
            $table->string('subject')->nullable();
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->enum('discount_type', ['%', 'fixed'])->default('%');
            $table->decimal('discounted_amount', 10, 2)->nullable();
            $table->decimal('subtotal', 8, 2)->default(0.00);
            $table->decimal('total', 8, 2)->default(0.00);
            $table->decimal('due', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('send_reminder')->default(true);
            $table->date('last_reminder_date')->nullable();
            $table->decimal('due_amount', 8, 2)->nullable();
            $table->timestamps();

            // Foreign keys (if needed, depending on your related tables)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
