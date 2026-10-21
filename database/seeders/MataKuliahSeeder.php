<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $si = ProgramStudi::where('kode_prodi', 'SI')->firstOrFail();

        $rows = [
            ['kode_mk' => 'SI101', 'nama_mk' => 'Pengantar Sistem Informasi', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'SI202', 'nama_mk' => 'Basis Data', 'sks' => 3, 'semester' => 2],
            ['kode_mk' => 'SI303', 'nama_mk' => 'Pemrograman Berbasis Web Lanjut', 'sks' => 3, 'semester' => 3],
        ];

        foreach ($rows as $row) {
            MataKuliah::updateOrCreate(
                ['kode_mk' => $row['kode_mk']],
                $row + ['program_studi_id' => $si->id, 'status_aktif' => true]
            );
        }
    }
}
