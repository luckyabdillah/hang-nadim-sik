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
            'email' => 'luckyabdillah00@gmail.com',
        ]);

        Copy::create([
            'name' => 'VP Airport Safety and Security',
            'email' => 'luckyabdillah00@gmail.com',
        ]);

        Copy::create([
            'name' => 'VP Airport Maintenance & Readiness',
            'email' => 'luckyabdillah00@gmail.com',
        ]);

        Copy::create([
            'name' => 'VP Business & Development',
            'email' => 'luckyabdillah00@gmail.com',
        ]);

        Copy::create([
            'name' => 'Airport Duty Manager',
            'email' => 'luckyabdillah00@gmail.com',
        ]);

        Copy::create([
            'name' => 'Terminal and Landside Services Team Leader',
            'email' => 'luckyabdillah00@gmail.com',
        ]);
    }
}
