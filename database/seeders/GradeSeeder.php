<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Container\Attributes\DB;
use App\Models\Grade;


class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            'Junior',
            'Mid-level',
            'Senior',
            'Lead',
        ];
        foreach($grades as $grade){
            Grade::create(['name'=>$grade]);
        }
    }
}
