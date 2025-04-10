<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\Role;

class EzimeetingRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'description' => "SuperUser" ,
            'text' => "Super User",
            'is_active' => true,
        ]);

        Role::create([
            'description' => "Admin",
            'text' => "System Administrator",
            'is_active' => true,
        ]);

        Role::create([
            'description' => "CorpAdmin",
            'text' => "Corporation Administrator",
            'is_active' => true,
        ]);

        Role::create([
            'description' => "Organizer",
            'text' => "Can Run a meeting",
            'is_active' => true,
        ]);

        Role::create([
            'description' => "Attendee",
            'text' => "Can attend a meeting",
            'is_active' => true,
        ]);

        Role::create([
            'description' => "User",
            'text' => "System User",
            'is_active' => true,
        ]);

    }
}
