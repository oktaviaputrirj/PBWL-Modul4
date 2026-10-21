<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $si = ProgramStudi::updateOrCreate(
            ['kode_prodi' => 'SI'],
            ['nama_prodi' => 'Sistem Informasi', 'jenjang' => 'S1']
        );

        ProgramStudi::updateOrCreate(
            ['kode_prodi' => 'IF'],
            ['nama_prodi' => 'Informatika', 'jenjang' => 'S1']
        );
    }
}
