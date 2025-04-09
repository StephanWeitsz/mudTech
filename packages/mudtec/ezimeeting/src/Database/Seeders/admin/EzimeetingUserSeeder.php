<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Role;

class EzimeetingUserSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superRole = Role::where('description', 'SuperUser')->first();
        $adminRole = Role::where('description', 'Admin')->first();
        $userRole = Role::where('description', 'User')->first();

        User::create([
            'name' => "admin",
            'email' => "stevewe@me.com",
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('Passw0rd'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ])->assignRole($superRole);

        User::create([
            'name' => "Stephan Weitsz",
            'email' => "jstevewe@gmail.com",
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('Passw0rd'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ])->assignRole($adminRole);

        User::create([
            'name' => "Shawn Jordaan",
            'email' => "darth.jordy@gmail.com",
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('Passw0rd'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ])->assignRole($adminRole);

        for($i=0;$i<100;$i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('Passw0rd'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
            ])->assignRole($userRole);
        }

        //User::factory()->count(10)->create()->assignRole($userRole);
    }
}
