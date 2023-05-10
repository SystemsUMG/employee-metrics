<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Department::create(['name' => 'Gerencia',                     'alias' => 'management']);
         Department::create(['name' => 'Investigación y Desarrollo',   'alias' => 'rd']);
         Department::create(['name' => 'Recursos Humanos',             'alias' => 'hr']);
         Department::create(['name' => 'Finanzas',                     'alias' => 'finances']);
         Department::create(['name' => 'Operaciones',                  'alias' => 'operations']);
         Department::create(['name' => 'Tecnología de la Información', 'alias' => 'it']);
    }
}
