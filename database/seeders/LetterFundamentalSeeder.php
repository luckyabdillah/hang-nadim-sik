<?php

namespace Database\Seeders;

use App\Models\LetterFundamental;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterFundamentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LetterFundamental::create([
            'reference' => 'Undang - Undang Republik Indonesia Nomor 1 Tahun 2009 Tentang Penerbangan',
            'position' => 1,
        ]);

        LetterFundamental::create([
            'reference' => 'Undang - Undang Republik Indonesia Nomor 1 Tahun 1970 Tentang Keselamatan Kerja',
            'position' => 2,
        ]);

        LetterFundamental::create([
            'reference' => 'SKEP/100/XI/1985 Tentang Peraturan & Tata Tertib Bandar Udara',
            'position' => 3,
        ]);
    }
}
