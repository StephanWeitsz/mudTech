<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Mudtec\Ezimeeting\Models\MeetingLocation;


class EzimeetingMeetingLocationSeeder extends Seeder
{
       /**
     * Run the database seeds.
     */
    public function run(): void
    {

      $corporations = DB::table('corporations')->select('id')->get();
      $corpCnt = count($corporations);

      MeetingLocation::create([
        'description' => "ONLINE",
        'text' => "Online",
        'corporation_id' => 1,
        'is_active' => true,
      ]);

      for($i=0;$i<60;$i++) {
        MeetingLocation::create([
          'description' => fake()->word . " " . fake()->numberBetween(1, 50),
          'text' => fake()->text(200),
          'corporation_id' => fake()->numberBetween(1, $corpCnt),
          'is_active' => true,
        ]);
      }
    }
}
