<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\DelegateRole;

class EzimeetingDelegateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.//    -
     */
    public function run(): void
    {
        DelegateRole::create([
            'description' => "Scribe",
            'text' => fake()->text(200),
            'is_active' => true, 
        ]);

        DelegateRole::create([
            'description' => "Attendee",
            'text' => fake()->text(200),
            'is_active' => true, 
        ]);

        DelegateRole::create([
            'description' => "Moderator",
            'text' => fake()->text(200),
            'is_active' => true, 
        ]);

        DelegateRole::create([
            'description' => "Presenter",
            'text' => fake()->text(200),
            'is_active' => true, 
        ]);
        
        DelegateRole::create([
            'description' => "Speaker",
            'text' => fake()->text(200),
            'is_active' => true, 
        ]);

        DelegateRole::create([
            'description' => "Guest",
            'text' => fake()->text(200),
            'is_active' => true, 
        ]);

    }
}
