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
        Schema::create('meeting_minute_actions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('text')->nullable();
            $table->timestamp('date_logged');
            $table->timestamp('date_due')->nullable();
            $table->timestamp('date_due_revised')->nullable(); 
            $table->timestamp('date_closed')->nullable();
            $table->foreignId('meeting_minute_note_id')->constrained('meeting_minute_notes')->onDelete('cascade');
            $table->foreignId('meeting_minute_action_status_id')->constrained('meeting_minute_action_statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_minute_actions');
    }
};
