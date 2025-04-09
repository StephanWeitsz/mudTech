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
        Schema::create('action_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_minute_action_id')->constrained('meeting_minute_actions')->onDelete('cascade');
            $table->foreignId('meeting_delegate_id')->constrained('meeting_delegates')->onDelete('cascade');
            $table->timestamps();
 
            $table->unique(['meeting_minute_action_id', 'meeting_delegate_id'], 'action_delegate_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_responsibilities');
    }
};
