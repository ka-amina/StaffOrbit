<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Human Resources',
            'Information Technology',
            'Finance',
            'Marketing',
            'Operations',
            'Research & Development',
            'Customer Service',
            'Sales',
            'Legal',
            'Administration'
        ];
        foreach($departments as $departement){
            Department::create(['name'=>$departement]);
        }
    }
}
