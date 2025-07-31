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
        $users = [
            [
                'username' => 'admin',
                'isAdmin' => true,
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin'))

            ],
            [
                'username' => 'gestor',
                'isAdmin' => false,
                'password' => Hash::make('gestor')
            ]
        ];
        foreach ($users as $user){
            User::updateOrCreate($user);
        }
    }
}
