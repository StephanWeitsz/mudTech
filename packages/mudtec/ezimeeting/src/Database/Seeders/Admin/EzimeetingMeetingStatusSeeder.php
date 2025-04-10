<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\MeetingStatus;

class EzimeetingMeetingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingStatus::create([
            'description' => "New",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingStatus::create([
            'description' => "Active",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingStatus::create([
            'description' => "In-Progress",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingStatus::create([
            'description' => "Completed",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ]);

        MeetingStatus::create([
            'description' => "OnHold",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ]);

        MeetingStatus::create([
            'description' => "Canceled",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ]);

        MeetingStatus::create([
            'description' => "Closed",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ]);

        MeetingStatus::create([
            'description' => "reOpend",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ]);

    }
}
