<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Lucky Abdillah',
            'email' => 'luckyabdillah00@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::create([
            'name' => 'Rizky Alfiansyah',
            'email' => 'rizky.alfiansyah2006@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::create([
            'name' => 'Keysya Arghinaya',
            'email' => 'keysyarghinaya.2006@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::create([
            'name' => 'Nauval Widaya',
            'email' => 'nauvalwidaya@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::create([
            'name' => 'Ziva Dasfi Sadira',
            'email' => 'zivadasfi@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::create([
            'name' => 'Jainal Arthur Sibuea',
            'email' => 'jainalsibuea05@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        $this->call([
            ApproverSeeder::class,
            VendorSeeder::class,
            WorkTypeSeeder::class,
            WorkLocationSeeder::class,
            CopySeeder::class,
            WorkPermitLetterSeeder::class,
            LetterFundamentalSeeder::class,
        ]);
    }
}
