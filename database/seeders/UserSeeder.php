<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Usuario Administrador',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'age'      => '23',
            'department_id' => 2
        ]);

        User::factory(10)->create();
    }
}
