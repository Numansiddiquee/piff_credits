<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('fname')->nullable()->after('name');
            $table->string('lname')->nullable()->after('fname');
            $table->string('phone')->nullable()->after('email');
        });
    }

    


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'fname', 'lname', 'phone'
            ]);
        });
    }
};
