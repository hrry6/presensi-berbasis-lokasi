<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $datas = [1, 2, 3, 4, 5];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 1; $i++) {
                DB::table('presensi_siswa')->insert([
                    'id_presensi' => $data,
                    'id_siswa' => $data,
                    'foto_bukti' => $faker->image(),
                    'jam_masuk' =>  $faker->time(),
                    'tanggal' => $faker->date(),
                    'status_kehadiran' => Arr::random(['Hadir', 'Izin', 'Alpha'])
                ]);
            }
        }
    }
}