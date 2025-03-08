<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $permissions = [

            'create-user',
            'edit-user',
            'delete-user',
            'update-profile',
            'manage departments',
            'view departments',

            // Employee permissions
            'update-personal-information',

            // Employee Management
            'add-employee',
            'edit-employee',
            'delete-employee',
            'update-career-info',

            // User Management
            'manage-users',

            // Career Tracking
            'track-career-progression',

            'manage-leave',

            'manage-jobs',
            'manage-grades',
            'manage-contracts',
            'manage-formation',

            'manager-accept',
            'rh-accept',
            'add-manager'
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
