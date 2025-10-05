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
        Schema::create('quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id', 255)->nullable()->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('reference', 255)->nullable();
            $table->date('quote_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('subject', 255)->nullable();
            $table->text('client_notes')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->string('discount_type',255)->nullable();
            $table->decimal('discount_value', 12, 2)->nullable();
            $table->decimal('total_discount', 12, 2)->nullable()->default(0.00);
            $table->string('adjustment_field', 255)->nullable();
            $table->decimal('adjustment_value', 12, 2)->nullable()->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            $table->text('terms_and_conditions')->nullable();
            $table->string('status', 255)->nullable();
            $table->timestamps();

            // 🔹 Optional foreign keys (uncomment if you have these tables)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
