<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\MeetingInterval;

class EzimeetingMeetingIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingInterval::create([
            'description' => "Once Off",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "",
            'is_active' => true, 
        ]);

        MeetingInterval::create([
            'description' => "Daily",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+1d",
            'is_active' => true, 
        ]);

        MeetingInterval::create([
            'description' => "Weekly",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+1w",
            'is_active' => true,
        ]);

        MeetingInterval::create([
            'description' => "Bi-Weekly",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+2w",
            'is_active' => true,
        ]);
        
        MeetingInterval::create([
            'description' => "Monthly",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+1m",
            'is_active' => true,
        ]);

        MeetingInterval::create([
            'description' => "Quarterly",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+3m",
            'is_active' => true,
        ]);

        MeetingInterval::create([
            'description' => "Annually",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+1y",
            'is_active' => true,
        ]);

        MeetingInterval::create([
            'description' => "Custom",
            'text' => fake()->text(200),
            'order'=> fake()->numberBetween(0, 100),
            'formula' => "+14d",
            'is_active' => true,
        ]);
                
    }
}
