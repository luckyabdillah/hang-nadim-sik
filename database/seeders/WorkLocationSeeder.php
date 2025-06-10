<?php

namespace Database\Seeders;

use App\Models\WorkLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkLocation::create([
            'location' => 'Gerai FF. 01',
            'description' => 'Dekat Gate A3',
        ]);

        WorkLocation::create([
            'location' => 'Gerai FF. 02',
            'description' => 'Dekat Gate A3',
        ]);

        WorkLocation::create([
            'location' => 'Gerai FF. 03',
            'description' => 'Dekat Gate A3',
        ]);

        WorkLocation::create([
            'location' => 'Gerai FF. 04',
            'description' => 'Dekat Gate A3',
        ]);

        WorkLocation::create([
            'location' => 'Gerai FF. 05',
            'description' => 'Dekat Gate A3',
        ]);
    }
}
