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
        Schema::create('meeting_minute_descriptors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_minute_id')->constrained('meeting_minutes')->onDelete('cascade');
            $table->foreignId('meeting_minute_item_id')->constrained('meeting_minute_items')->onDelete('cascade');
            $table->unsignedBigInteger('parent_descriptor_id')->nullable()->index();
            $table->morphs('descriptor');
            $table->timestamp('date_logged');
            $table->timestamp('date_due')->nullable();
            $table->timestamp('date_revised')->nullable(); 
            $table->timestamp('date_closed')->nullable();
            $table->timestamps();

            $table->unique(['meeting_minute_id', 'meeting_minute_item_id']);
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
