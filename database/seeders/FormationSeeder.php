<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Formation;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formations = [
            [
                'nom' => 'Formation Laravel',
                'type' => 'Development',
                'date_formation' => '2025-03-10',
            ],
            [
                'nom' => 'Formation React',
                'type' => 'Frontend',
                'date_formation' => '2025-03-12',
            ],
            [
                'nom' => 'Formation PHP',
                'type' => 'Backend',
                'date_formation' => '2025-03-15',
            ],
            [
                'nom' => 'Formation JavaScript',
                'type' => 'Frontend',
                'date_formation' => '2025-03-20',
            ],
            [
                'nom' => 'Formation Python',
                'type' => 'Backend',
                'date_formation' => '2025-03-25',
            ],
            [
                'nom' => 'Formation Data Science',
                'type' => 'Data',
                'date_formation' => '2025-03-30',
            ],
            [
                'nom' => 'Formation UX/UI Design',
                'type' => 'Design',
                'date_formation' => '2025-04-05',
            ],
            [
                'nom' => 'Formation DevOps',
                'type' => 'Operations',
                'date_formation' => '2025-04-10',
            ],
            [
                'nom' => 'Formation Cybersecurity',
                'type' => 'Security',
                'date_formation' => '2025-04-15',
            ],
            [
                'nom' => 'Formation Cloud Computing',
                'type' => 'Cloud',
                'date_formation' => '2025-04-20',
            ],
        ];

        // Loop through and create the records
        foreach ($formations as $formation) {
            Formation::create($formation);
        }
    }
}
