<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

//use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;

class EzimeetingDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        Department::create([
            'name' => "Software Development",
            'description' => fake()->text(100),
            'text' => fake()->text(200),
            'corporation_id' => 1,
        ]);

        Department::create([
            'name' => "Infastructure",
            'description' => fake()->text(100),
            'text' => fake()->text(200),
            'corporation_id' => 1,
        ]);

        Department::create([
            'name' => "New Bussiness",
            'description' => fake()->text(100),
            'text' => fake()->text(200),
            'corporation_id' => 1,
        ]);

        Department::create([
            'name' => "Committee",
            'description' => fake()->text(100),
            'text' => fake()->text(200),
            'corporation_id' => 2,
        ]);

        Department::create([
            'name' => "Security & New Tecknologies",
            'description' => fake()->text(100),
            'text' => fake()->text(200),
            'corporation_id' => 2,
        ]);

        Department::create([
            'name' => "Marketing",
            'description' => fake()->text(100),
            'text' => fake()->text(200),
            'corporation_id' => 2,
        ]);


        $corporations = DB::table('corporations')->select('id')->get();
        for($i=0;$i<30;$i++) {
            $randomCorporationId = $corporations->isNotEmpty() ? $corporations->random()->id : null;

            Department::create([
                'name' => fake()->word,
                'description' => fake()->text(100),
                'text' => fake()->text(200),
                'corporation_id' => $randomCorporationId,
            ]);
        } 
    }
}
