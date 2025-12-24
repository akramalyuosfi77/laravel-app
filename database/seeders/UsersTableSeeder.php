<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    public function run(): void
    {

        // $doctors = Doctor::all();

        // foreach ($doctors as $doctor) {
        //     $user = User::where('name', $doctor->name)->first();
        //     if ($user) {
        //         $doctor->user_id = $user->id;
        //         $doctor->save();
        //     }
        //     }

        

        // مدير
        DB::table('users')->insert([
            'name' => 'Akram Admin',
            'email' => 'admin@nooris.me',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // دكتور
        DB::table('users')->insert([
            'name' => 'Wael Doctor',
            'email' => 'doctor@nooris.me',
            'role' => 'doctor',
            'password' => Hash::make('doctor123'),
            'email_verified_at' => now(),
        ]);

        // طالب
        DB::table('users')->insert([
            'name' => 'Student Test',
            'email' => 'student@nooris.me',
            'role' => 'student',
            'password' => Hash::make('student123'),
            'email_verified_at' => now(),
        ]);
    }
}
