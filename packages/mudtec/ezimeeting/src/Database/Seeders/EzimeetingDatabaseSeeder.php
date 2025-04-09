<?php

namespace Mudtec\Ezimeeting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EzimeetingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingRoleSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingUserSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingCorporationSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingDepartmentSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingMeetingStatusSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingActionStatusSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingAttendeeStatusSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingDelegateRoleSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingMeetingIntervalSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Admin\EzimeetingMeetingLocationSeeder::class,
            \Mudtec\Ezimeeting\Database\Seeders\Meeting\EzimeetingMeetingSeeder::class,
        ]);
    }
}


