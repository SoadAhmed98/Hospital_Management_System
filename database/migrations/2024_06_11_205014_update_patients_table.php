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
        Schema::table('patients', function (Blueprint $table) {
            // Adding new columns
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();

            // Dropping the foreign key constraint
            $table->dropForeign(['user_id']);

            // Removing the user_id column
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Dropping the newly added columns
            $table->dropColumn(['name', 'email', 'email_verified_at', 'password', 'phone']);

            // Adding the user_id column back
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
