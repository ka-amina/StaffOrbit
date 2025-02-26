<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractType;


class ContractTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contractTypes = [
            ['name' => 'CDI', 'description' => 'Contrat à Durée Indéterminée'],
            ['name' => 'CDD', 'description' => 'Contrat à Durée Déterminée'],
            ['name' => 'Stage', 'description' => 'Contrat de Stage'],
            ['name' => 'Freelance', 'description' => 'Contrat Freelance'],
        ];
        foreach ($contractTypes as $type) {
            ContractType::create($type);
        }
    }
}
