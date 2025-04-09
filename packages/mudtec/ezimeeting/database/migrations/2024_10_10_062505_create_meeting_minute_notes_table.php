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
        Schema::create('meeting_minute_notes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('text')->nullable();
            $table->timestamp('date_logged');
            $table->timestamp('date_closed')->nullable();
            $table->foreignId('meeting_minute_item_id')->constrained('meeting_minute_items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_minute_notes');
    }
};
