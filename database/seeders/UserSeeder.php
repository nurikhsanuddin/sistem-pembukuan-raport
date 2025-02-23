<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //user seeder
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@sispem.id',
                'password' => bcrypt('admin123'),

            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
