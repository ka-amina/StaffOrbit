<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin= Role::create(['name' => 'Admin']);
        $employee = Role::create(['name' => 'Employee']);
        $rh = Role::create(['name' => 'Rh']);
        $manager = Role::create(['name' => 'Manager']);

        // $admin->givePermissionTo(Permission::all());

        // $employee ->givePermissionTo([
        //     'update-profile',
        //     'view departments'
        // ]);

        // $admin = Role::findByName('Admin');
        // $employee = Role::findByName('Employee');
        // $rh = Role::findByName('Rh');
        // $manager = Role::findByName('Manager');

        $admin->givePermissionTo(Permission::all());

        $employee->givePermissionTo([
            'track-career-progression',
            'update-profile',


        ]);

        $rh->givePermissionTo([
            'manage-users',
            'add-employee',
            'edit-employee',
            'delete-employee',
            'update-career-info',
            'manage-departments',
            'assign-departments',
            'view departments',
            'track-career-progression',
            'manage-leave',

            'manage-contracts',
            'manage-formation',
            'rh-accept',
            'add-manager'
        ]);

        $manager->givePermissionTo([
            'manage-users',
            'add-employee',
            'edit-employee',
            'delete-employee',
            'view departments',
            'update-career-info',
            'track-career-progression',
            'manage-leave',
            'manage-contracts',
            'manage-formation',
            'manager-accept',

        ]);
    }
}
