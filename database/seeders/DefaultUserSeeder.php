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
        $admin= User::create([
            'name'=>'amina kara',
            'email'=>'aminakara400@gmail.com',
            'password' => Hash::make('12345678')

        ]);
        $admin->assignRole('Admin');

        $rh= User::create([
            'name'=>'',
            'email'=>'amina@employee.com',
            'password'=>Hash::make('12345678')   
        ]);
        $rh->assignRole('rh');
        
        $adminUser = User::find(1); 
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }
    }
}
