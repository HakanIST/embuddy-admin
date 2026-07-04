<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@uskudar.edu.tr'],
            [
                'name' => 'EmBuddy Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->command->info('✅ Admin user created: admin@uskudar.edu.tr / admin123');
    }
}
