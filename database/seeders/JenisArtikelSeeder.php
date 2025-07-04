<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
           
            [
                'id_jenis' => 1,
                'jenis_artikel'=>'Softnews',
            ],
             [
                'id_jenis' => 2,
                'jenis_artikel'=>'Hardnews',
            ]

        ];

        DB::table('m_jenis_artikel')->insert($data);
    }
}
