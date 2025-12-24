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
        // إنشاء حساب المدير
        User::create([
            'name' => 'Akram Admin',
            'email' => 'admin@nooris.me',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
        ]);

        // إنشاء حساب الدكتور
        User::create([
            'name' => 'Wael Doctor',
            'email' => 'doctor@nooris.me',
            'role' => 'doctor',
            'password' => bcrypt('doctor123'),
            'email_verified_at' => now(),
        ]);

        // إنشاء حساب الطالب
        User::create([
            'name' => 'Student Test',
            'email' => 'student@nooris.me',
            'role' => 'student',
            'password' => bcrypt('student123'),
            'email_verified_at' => now(),
        ]);
    }
}
