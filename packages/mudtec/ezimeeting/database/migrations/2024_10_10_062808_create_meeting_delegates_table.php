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
        
        Schema::create('meeting_delegates', function (Blueprint $table) {//-
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->onDelete('cascade'); 
            $table->string('delegate_name');
            $table->string('delegate_email');
            $table->foreignId('delegate_role_id')->constrained('delegate_roles')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_meeting_delegates');
    }
};

