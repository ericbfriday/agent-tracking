<?php

use Vanguard\Role;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spymaster = Role::where('name', 'Spymaster')->first();

        User::create([
            'first_name' => 'Spymaster',
            'email' => 'spymaster@goonswarm.com',
            'username' => 'Spymaster',
            'password' => 'blackhand',
            'avatar' => null,
            'country_id' => null,
            'role_id' => $spymaster->id,
            'status' => UserStatus::ACTIVE
        ]);
        

        $admin = Role::where('name', 'Admin')->first();

        User::create([
            'first_name' => 'Admin',
            'email' => 'admin@goonswarm.com',
            'username' => 'Admin',
            'password' => 'admin1234',
            'avatar' => null,
            'country_id' => null,
            'role_id' => $admin->id,
            'status' => UserStatus::ACTIVE
        ]);
    }
}
