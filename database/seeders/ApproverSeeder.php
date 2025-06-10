<?php

namespace Database\Seeders;

use App\Models\Approver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApproverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Approver::create([
            'user_id' => 1,
            'position' => 'VP Airport Services',
            'level' => 1,
            'signature' => 'signatures/sign1.png',
        ]);

        Approver::create([
            'user_id' => 2,
            'position' => 'Terminal & Landside Services Senior Manager',
            'level' => 2,
            'signature' => 'signatures/sign2.png',
        ]);

        Approver::create([
            'user_id' => 6,
            'position' => 'Chief Executive Officer',
            'level' => 3,
            'is_default_approver' => 0,
        ]);
    }
}
