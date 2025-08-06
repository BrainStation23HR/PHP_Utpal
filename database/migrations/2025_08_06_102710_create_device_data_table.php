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
        Schema::create('device_data', function (Blueprint $table) {
            $table->id();
            $table->uuid('device_id');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            
            // Explicit columns for core data points
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();
            $table->string('status')->nullable();
            
            // Add a JSON column for any additional, less-frequently accessed sensor data
            $table->json('additional_data')->nullable(); 

            // Use 'timestamp' for the specific event time.
            // Laravel's `timestamps()` will handle `created_at` and `updated_at`.
            $table->timestamp('event_timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_data');
    }
};
