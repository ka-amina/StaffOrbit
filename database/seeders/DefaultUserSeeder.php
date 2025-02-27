<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::create([
            'name' => 'amina kara',
            'email' => 'aminakara400@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar' => null,
            'phone' => null,
            'birth_date' => now(),
            'address' => null,
            'recruitment_date' => now(),
            'contract_type' => 1,
            'departement_id' => 1,
            'salary' => 5000.00,
            'status' => 'active',
        ]);
        $admin->assignRole('Admin');

        // Create HR user
        $rh = User::create([
            'name' => 'Amina Employee',
            'email' => 'amina@employee.com',
            'password' => Hash::make('12345678'),
            'avatar' => null,
            'phone' => null,
            'birth_date' => now(),
            'address' => null,
            'recruitment_date' => now(),
            'contract_type' => 1,
            'departement_id' => 2,
            'salary' => 3000.00,
            'status' => 'active',
        ]);
        $rh->assignRole('rh');

        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }
    }
}
