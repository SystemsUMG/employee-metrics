<?php

namespace Database\Seeders;

use App\Models\Kpi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNotIn('id', [1])->get();

        foreach ($users as $user) {
            for ($count = 1; $count <= 4; $count++) {
                $kpiType = $count;
                $value = '';

                switch ($kpiType) {
                    case 1:
                        $value = fake()->numberBetween(3000, 50000);
                        break;
                    case 2:
                        $value = fake()->numberBetween(1, 4);
                        break;
                    case 3:
                        $value = fake()->numberBetween(1, 6);
                        break;
                    case 4:
                        $value = fake()->numberBetween(0, 15);
                        break;
                }

                Kpi::create([
                    'value'       => $value,
                    'kpi_type_id' => $kpiType,
                    'user_id'     => $user->id
                ]);
            }
        }
    }
}
