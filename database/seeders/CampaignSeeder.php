<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaign::create([
            'thumbnail' => 'campaigns/1.jpg',
            'title' => 'Bantu Anak Kost Ini Hidup Mevvah',
            'slug' => 'bantu-anak-kost-ini-hidup-mevvah',
            'story' => 'Anak kost ini telah lelah dengan kehidupannya yang b aja dan harus makan tempe setiap hari. Ya kadang juga makan ayam sih, tapi kan pengen sekali-kali makan beef yang bukan daging rendang dari nasi padang 10 ribuan. AWOKAOWKAOWAOWKAOWK',
            'target' => '500000000',
            'end_date' => '2023-12-31'
        ]);

        Campaign::create([
            'thumbnail' => 'campaigns/1.jpg',
            'title' => 'Anak Kost Ini Pengen Hidup Mevvah',
            'slug' => 'anak-kost-ini-pengen-hidup-mevvah',
            'story' => 'Anak kost ini telah lelah dengan kehidupannya yang b aja dan harus makan tempe setiap hari. Ya kadang juga makan ayam sih, tapi kan pengen sekali-kali makan beef yang bukan daging rendang dari nasi padang 10 ribuan. AWOKAOWKAOWAOWKAOWK',
            'target' => '500000000',
            'end_date' => '2023-12-31'
        ]);
    }
}
