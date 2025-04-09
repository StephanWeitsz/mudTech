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
        Schema::create('meeting_attendees', function (Blueprint $table) {//-
            $table->id();
            $table->foreignId('minute_id')->constrained('meeting_minutes')->onDelete('cascade');
            $table->foreignId('meeting_delegate_id')->constrained('meeting_delegates')->onDelete('cascade'); 
            $table->foreignId('meeting_attendee_status_id')->constrained('meeting_attendee_statuses')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_attendees');
    }
};
