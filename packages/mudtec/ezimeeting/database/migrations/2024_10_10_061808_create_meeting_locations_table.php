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
        Schema::create('meeting_locations', function (Blueprint $table) {//-
            $table->id();
            $table->string('description');
            $table->string('text')->nullable();
            $table->foreignId('corporation_id')->constrained('corporations')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['description', 'corporation_id'], 'meeting_locations_description_corporation_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_locations');
    }
};

