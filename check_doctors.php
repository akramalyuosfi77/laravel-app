<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking Doctors Table...\n";
$doctorsCount = \App\Models\Doctor::count();
echo "Total Doctors in 'doctors' table: " . $doctorsCount . "\n";

if ($doctorsCount > 0) {
    echo "List of Doctors:\n";
    foreach (\App\Models\Doctor::all() as $doctor) {
        echo "- ID: " . $doctor->id . ", Name: " . $doctor->name . ", UserID: " . $doctor->user_id . "\n";
    }
} else {
    echo "WARNING: The 'doctors' table is EMPTY!\n";
    echo "Checking 'users' table for role 'doctor'...\n";
    $usersCount = \App\Models\User::where('role', 'doctor')->count();
    echo "Total Users with role 'doctor': " . $usersCount . "\n";
    
    if ($usersCount > 0) {
        echo "Found users with role 'doctor'. They might not be synced to the 'doctors' table.\n";
        $users = \App\Models\User::where('role', 'doctor')->get();
        foreach($users as $user) {
             echo "- User ID: " . $user->id . ", Name: " . $user->name . ", Email: " . $user->email . "\n";
        }
    }
}
