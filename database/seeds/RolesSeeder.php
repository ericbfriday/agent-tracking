<?php

use Vanguard\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'description' => 'System administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'User',
            'display_name' => 'User',
            'description' => 'Default system user.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'Handler',
            'display_name' => 'Handler',
            'description' => 'Default system user.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'Spymaster',
            'display_name' => 'Spymaster',
            'description' => 'Default system user.',
            'removable' => false
        ]);
    }
}
