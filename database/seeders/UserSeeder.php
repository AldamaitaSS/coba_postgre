<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // [
            //     'id_user'=> 1,
            //     'id_level' => 1,
            //     'nama' => 'Admin',
            //     'username' => 'admin123',
            //     'password' => Hash::make('password123'),
            // ],
            [
                'id_user'=> 2,
                'id_level' => 3,
                'nama' => 'Aldamaita Salwa Salsabila',
                'username' => 'aldamaita',
                'password' => Hash::make('password123'),
            ],
            [
                'id_user'=> 3,
                'id_level' => 3,
                'nama' => 'Amanda Jasmine',
                'username' => 'amanda',
                'password' => Hash::make('password123'),
            ],
            [
                'id_user'=> 4,
                'id_level' => 3,
                'nama' => 'Fardiyani Afroul Yasinta',
                'username' => 'fafa',
                'password' => Hash::make('password123'),
            ],

        ];

        DB::table('m_user')->insert($data);
    }
}
