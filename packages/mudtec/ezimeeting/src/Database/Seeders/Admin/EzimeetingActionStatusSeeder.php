<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\MeetingMinuteActionStatus;

class EzimeetingActionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        MeetingMinuteActionStatus::create([
            'description' => "New",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingMinuteActionStatus::create([
            'description' => "In Progress",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingMinuteActionStatus::create([
            'description' => "Canceled",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

        MeetingMinuteActionStatus::create([
            'description' => "Done",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ]);

        MeetingMinuteActionStatus::create([
            'description' => "on Hold",
            'text' => fake()->text(200),
            'color' => fake()->hexColor,
            'order' => fake()->numberBetween(0, 100),
            'is_active' => true,    
        ]);

    }
}
