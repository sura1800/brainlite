<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'spadmin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $manager = User::create([
            'name' => 'writer',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password')
        ]);
        $sp_admin_role = Role::create(['name' => 'Super-Admin']);
        $admin_role = Role::create(['name' => 'admin']);
        $manager_role = Role::create(['name' => 'manager']);

        // $permission = Permission::create(['name' => 'Post access']);
        // $permission = Permission::create(['name' => 'Post edit']);
        // $permission = Permission::create(['name' => 'Post create']);
        // $permission = Permission::create(['name' => 'Post delete']);

        $permission = Permission::create(['name' => 'Role access']);
        $permission = Permission::create(['name' => 'Role edit']);
        $permission = Permission::create(['name' => 'Role create']);
        $permission = Permission::create(['name' => 'Role delete']);

        $permission = Permission::create(['name' => 'User access']);
        $permission = Permission::create(['name' => 'User edit']);
        $permission = Permission::create(['name' => 'User create']);
        $permission = Permission::create(['name' => 'User delete']);

        $permission = Permission::create(['name' => 'Permission access']);
        $permission = Permission::create(['name' => 'Permission edit']);
        $permission = Permission::create(['name' => 'Permission create']);
        $permission = Permission::create(['name' => 'Permission delete']);

        // $permission = Permission::create(['name' => 'Programme access']);
        // $permission = Permission::create(['name' => 'Programme edit']);
        // $permission = Permission::create(['name' => 'Programme create']);
        // $permission = Permission::create(['name' => 'Programme delete']);

        // $permission = Permission::create(['name' => 'Schedule access']);
        // $permission = Permission::create(['name' => 'Schedule edit']);
        // $permission = Permission::create(['name' => 'Schedule create']);
        // $permission = Permission::create(['name' => 'Schedule delete']);

        // $permission = Permission::create(['name' => 'Meeting access']);
        // $permission = Permission::create(['name' => 'Meeting edit']);
        // $permission = Permission::create(['name' => 'Meeting create']);
        // $permission = Permission::create(['name' => 'Meeting delete']);


        $super_admin->assignRole($sp_admin_role);
        $admin->assignRole($admin_role);
        $manager->assignRole($manager_role);

        $admin_role->givePermissionTo(Permission::all());
    }
}
