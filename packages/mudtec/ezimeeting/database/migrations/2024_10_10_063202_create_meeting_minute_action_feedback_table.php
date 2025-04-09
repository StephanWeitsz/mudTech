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
        Schema::create('meeting_minute_action_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_minute_action_id')->constrained('meeting_minute_actions')->onDelete('cascade');
            $table->string('text');
            $table->timestamp('date_logged')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_minute_action_feedback');
    }
};
