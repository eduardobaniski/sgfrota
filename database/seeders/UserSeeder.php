<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();
        User::create([
            'name' => 'admin',
            'password' => Hash::make(env('ADMIN_PASSWORD', 'admin'))
        ]);
    }
}
