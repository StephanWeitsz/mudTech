<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\MeetingAttendeeStatus;

class EzimeetingAttendeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingAttendeeStatus::create([
            'description' => "Pressent",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingAttendeeStatus::create([
            'description' => "Not Pressent",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingAttendeeStatus::create([
            'description' => "Excused",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

    }
}
