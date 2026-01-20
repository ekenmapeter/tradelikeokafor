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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('proof')->nullable()->after('reference');
            $table->text('admin_notes')->nullable()->after('status');
        });

        // Since many DBs don't support easy enum changes, we'll just keep the existing enum
        // and handle 'rejected' as 'failed' or similar, but the user asked for approve/reject.
        // Actually, let's just make it a string if we want flexibility, but looking at previous migration it's enum.
        // I'll try to change it to string for simplicity in the future.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['proof', 'admin_notes']);
        });
    }
};
