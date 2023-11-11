<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $createdAt = Carbon::now();
            
            // if ($i % 3 === 0) {
            //     // Tahunan
            //     $createdAt = $createdAt->copy()->modify('-' . $i . ' years');
            // } elseif ($i % 2 === 0) {
            //     // Bulanan
            //     $createdAt = $createdAt->copy()->modify('-' . $i . ' months');
            // } else {
            //     // Harian
            //     $createdAt = $createdAt->copy()->modify('-' . $i . ' days');
            // }

            $bayar = $faker->numberBetween(10000, 50000);

            DB::table('penjualan')->insert([
                'id_member' => null,
                'total_item' => $faker->numberBetween(1, 10),
                'total_harga' => $bayar,
                'diskon' => 0,
                'bayar' => $bayar,
                'diterima' => $bayar,
                'id_user' => 1,
                'created_at' => $createdAt,
                'updated_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
