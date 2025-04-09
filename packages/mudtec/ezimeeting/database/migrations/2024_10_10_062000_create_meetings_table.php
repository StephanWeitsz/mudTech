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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('text')->nullable();
            $table->string('purpose')->nullable();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->timestamp('scheduled_at');
            $table->integer('duration');
            $table->foreignId('meeting_interval_id')->constrained('meeting_intervals')->onDelete('cascade');
            $table->foreignId('meeting_status_id')->constrained('meeting_statuses')->onDelete('cascade');
            $table->foreignId('meeting_location_id')->constrained('meeting_locations')->onDelete('cascade');
            $table->string('external_url')->nullable();
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
