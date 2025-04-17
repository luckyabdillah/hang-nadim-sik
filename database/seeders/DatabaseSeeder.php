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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Lucky Abdillah',
            'email' => 'luckyabdillah00@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::factory()->create([
            'name' => 'Rizky Alfiansyah',
            'email' => 'rizky.alfiansyah2006@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::factory()->create([
            'name' => 'Keysya Arghinaya',
            'email' => 'keysyarghinaya.2006@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::factory()->create([
            'name' => 'Nauval Widaya',
            'email' => 'nauvalwidaya@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::factory()->create([
            'name' => 'Ziva Dasfi Sadira',
            'email' => 'zivadasfi@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);

        User::factory()->create([
            'name' => 'Jainal Arthur Sibuea',
            'email' => 'jainalsibuea05@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'superuser',
        ]);
    }
}
