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

        

        //مدير
         // دكتور
       /* DB::table('users')->insert([
            'name' => 'Akram a',
            'email' => 'akram@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // دكتور
        DB::table('users')->insert([
            'name' => 'Wael d',
            'email' => 'doctor@gmail.com',
            'role' => 'doctor',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Wae d',
            'email' => 'doctor1@gmail.com',
            'role' => 'doctor',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now(),
        ]);


        // طالب
        DB::table('users')->insert([
            'name' => 'Alaa s',
            'email' => 'student@gmail.com',
            'role' => 'student',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);*/
    }
}
