<?php

namespace Database\Seeders;

use App\Models\KpiType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KpiTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KpiType::create(['name' => 'Salario',       'alias' => 'salary']);
        KpiType::create(['name' => 'Nivel Estudio', 'alias' => 'study_level']);
        KpiType::create(['name' => 'Antigüedad',    'alias' => 'antiquity']);
        KpiType::create(['name' => 'Ausencias',     'alias' => 'absences']);
        KpiType::create(['name' => 'Edad',          'alias' => 'age']);
    }
}
