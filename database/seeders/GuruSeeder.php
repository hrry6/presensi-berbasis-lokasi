<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Faker dengan region Indonesia
        $faker = Faker::create('id_ID');

        $datas = [2, 4, 5];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 5; $i++) {
                DB::table('guru')->insert([
                    'id_akun' => Arr::random(['7', '8', '9', '10', '11', '12']),
                    'nama_guru' => $faker->name(). Arr::random(['S.Pd', 'S.Kom']),
                    'foto_guru' => 'guru.jpg',
                    'pembuat' => 'Tata Usaha'
                ]);
            }
        }
    }
}
