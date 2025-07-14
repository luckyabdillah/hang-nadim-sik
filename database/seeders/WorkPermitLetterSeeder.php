<?php

namespace Database\Seeders;

use App\Models\WorkPermitLetter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkPermitLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkPermitLetter::create([
            'vendor_id' => 1,
            'work_type_id' => 1,
            'work_location' => 'Gerai FF. 01 (Dekat Gate A3)',
            'description' => 'Renovasi Gerai',
            'started_at' => '2025-05-01',
            'ended_at' => '2025-05-08',
            'external_pic_name' => 'Bambang',
            'external_pic_number' => '081283890098',
            'application_letter' => 'application_letters/1.pdf',
        ]);

        WorkPermitLetter::create([
            'vendor_id' => 1,
            'work_type_id' => 2,
            'work_location' => 'Gerai FF. 02 (Dekat Gate A3)',
            'description' => 'Renovasi Gerai',
            'started_at' => '2025-05-07',
            'ended_at' => '2025-05-12',
            'external_pic_name' => 'Budi',
            'external_pic_number' => '081283890099',
            'application_letter' => 'application_letters/2.pdf',
        ]);
    }
}
