<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_custom_fields_to_users_table.php
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone_number');
            $table->string('ktp_number')->unique()->nullable()->after('address');
            $table->string('role')->default('member')->after('ktp_number'); // member, admin
            $table->string('status')->default('pending')->after('role'); // pending, approved
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'address', 'ktp_number', 'role', 'status']);
        });
    }
};
