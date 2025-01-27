<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->has(Task::factory()->count(6))->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('secret'),
        ]);

        User::factory()->has(Task::factory()->count(6))->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('superSecret'),
        ]);
    }
}
