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
            Schema::create('tenants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Link to login
                $table->foreignId('room_id')->constrained(); // Current Room (one of your 15)
                
                $table->string('full_name');
                $table->string('phone_number')->unique(); // Essential for Bakong/Telegram
                $table->string('telegram_id')->nullable();
                
                // Bakong Specifics
                $table->string('bakong_account_id')->nullable(); // e.g., name@bank
                
                $table->date('move_in_date');
                $table->integer('deposit_amount')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
