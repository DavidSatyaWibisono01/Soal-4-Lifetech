<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'nis' => 'Value ' . $i,
                'nama' => 'Another Value ' . $i,
                'foto_siswa' => 'Another Value ' . $i,
                'nama' => 'Another Value ' . $i,
                'jenis_kelamin' => 'Another Value ' . $i,
                'jurusan' => 'Another Value ' . $i,
            ];
        }

        DB::table('siswa')->insert($data);
    }
}
