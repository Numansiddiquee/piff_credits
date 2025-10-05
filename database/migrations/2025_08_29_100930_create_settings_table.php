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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            // General Platform Settings
            ['name' => 'platform_name', 'value' => 'My Platform'],
            ['name' => 'platform_logo', 'value' => null],
            ['name' => 'platform_favicon', 'value' => null],
            ['name' => 'support_email', 'value' => 'support@example.com'],
            ['name' => 'support_contact_info', 'value' => null],
            ['name' => 'default_language', 'value' => 'en'],
            ['name' => 'default_timezone', 'value' => 'UTC'],
            ['name' => 'maintenance_mode', 'value' => '0'], // 0 = OFF, 1 = ON

            // Financial Settings
            ['name' => 'commission_rate', 'value' => '5'], // 5%
            ['name' => 'default_currency', 'value' => 'USD'],
            ['name' => 'minimum_withdrawal_amount', 'value' => '10'],
            ['name' => 'withdrawal_processing_time', 'value' => '3'], // days
            ['created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
