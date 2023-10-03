<?php

use Vanguard\Permission;
use Vanguard\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$adminRole = Role::where('name', 'Admin')->first();
    	$spymasterRole = Role::where('name', 'Spymaster')->first();

    	$permissions[] = Permission::create([
    		'name' => 'users.manage',
    		'display_name' => 'Manage Users',
    		'description' => 'Manage users and their sessions.',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'users.activity',
    		'display_name' => 'View System Activity Log',
    		'description' => 'View activity log for all system users.',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'roles.manage',
    		'display_name' => 'Manage Roles',
    		'description' => 'Manage system roles.',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'permissions.manage',
    		'display_name' => 'Manage Permissions',
    		'description' => 'Manage role permissions.',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'settings.general',
    		'display_name' => 'Update General System Settings',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'settings.auth',
    		'display_name' => 'Update Authentication Settings',
    		'description' => 'Update authentication and registration system settings.',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'settings.notifications',
    		'display_name' => 'Update Notifications Settings',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'groups.manage',
    		'display_name' => 'Manage Groups',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'agents.manage',
    		'display_name' => 'Manage Agents',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'handlers.manage',
    		'display_name' => 'Manage Handlers',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'metrics.view',
    		'display_name' => 'Metrics View',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'agents.can.contact',
    		'display_name' => 'Agent Contact Form Usage',
    		'description' => '',
    		'removable' => false
    	]);

    	$permissions[] = Permission::create([
    		'name' => 'posts.manage',
    		'display_name' => 'Spymaster Posts',
    		'description' => '',
    		'removable' => false
    	]);

    	    $permissions[] = Permission::create([
    		'name' => 'search.manage',
    		'display_name' => 'Spymaster Global Search',
    		'description' => '',
    		'removable' => false
    	]);

    	$adminRole->attachPermissions($permissions);
    	$spymasterRole->attachPermissions($permissions);
    }
}
