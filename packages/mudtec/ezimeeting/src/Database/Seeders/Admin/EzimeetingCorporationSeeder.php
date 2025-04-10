<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\Corporation;


class EzimeetingCorporationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Corporation::create([
            'name' => 'mudTECK',
            'description' => fake()->text(200),
            'text' => fake()->text(200),
            'website' => fake()->url,
            'email' => fake()->unique()->safeEmail(),
            'secret' => 'St@rWar5Cl0ne3s',
            'logo' => fake()->randomElement(['logo1.png', 'logo2.png', 'logo3.png']),
        ]);
           
        Corporation::create([
            'name' => "VRP HOME OWNERS ASSOSIATION",
            'description' => fake()->text(200),
            'text' => fake()->text(200),
            'website' => fake()->url,
            'email' => fake()->unique()->safeEmail(),
            'logo' => fake()->randomElement(['logo1.png', 'logo2.png', 'logo3.png']),
        ]);

        for($i=0;$i<10;$i++) {        
            Corporation::create([
            'name' => fake()->company,
                'description' => fake()->text(200),
                'text' => fake()->text(200),
                'website' => fake()->url,
                'email' => fake()->unique()->safeEmail(),
                'logo' => fake()->randomElement(['logo1.png', 'logo2.png', 'logo3.png']),
            ]);
        }
    }
}
