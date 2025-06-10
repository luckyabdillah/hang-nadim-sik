<?php

namespace Database\Seeders;

use App\Models\Copy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Copy::create([
            'name' => 'Direktur Operasi',
        ]);

        Copy::create([
            'name' => 'VP Airport Safety and Security',
        ]);

        Copy::create([
            'name' => 'VP Airport Maintenance & Readiness',
        ]);

        Copy::create([
            'name' => 'VP Business & Development',
        ]);

        Copy::create([
            'name' => 'Airport Duty Manager',
        ]);

        Copy::create([
            'name' => 'Terminal and Landside Services Team Leader',
        ]);
    }
}
