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

        $admin->givePermissionTo(Permission::all());

        $employee ->givePermissionTo([
            'update-profile',
            'view departments'
        ]);
        
    }
}
