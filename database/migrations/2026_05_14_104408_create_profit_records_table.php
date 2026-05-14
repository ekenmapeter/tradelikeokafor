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
        Schema::create('profit_records', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('student_name')->nullable();
            $table->decimal('profit_amount', 15, 2);
            $table->decimal('commission_received', 15, 2);
            $table->string('currency')->default('USD');
            $table->text('reason');
            $table->foreignId('admin_id')->constrained('users');
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_records');
    }
};
