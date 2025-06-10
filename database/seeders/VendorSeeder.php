<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::create([
            'legal_name' => 'CV. Media Kreasi Bangsa',
            'name' => 'Kek Pisang Vila',
        ]);

        Vendor::create([
            'legal_name' => 'CV. Cendana Jaya Abadi',
            'name' => 'Keripik Singkong Gohoky',
        ]);

        Vendor::create([
            'legal_name' => 'Liong Group Pte. Ltd.',
            'name' => 'Keripik Singkong Gohoky',
        ]);
    }
}
