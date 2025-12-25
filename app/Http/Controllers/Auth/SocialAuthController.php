<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('batch_id')) {
            session(['join_batch_id' => $request->batch_id]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication failed.');
        }

        // Check if the user already exists by google_id or email
        $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();

        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(24)),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        } else {
            // Update existing user with google_id and avatar if missing
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        }

        Auth::login($user);

        // Handle Batch Joining if coming from a join link
        $batchId = session('join_batch_id');
        if ($batchId && $user->role === 'student') {
            $batch = Batch::find($batchId);
            if ($batch) {
                // Check if student record exists or create it
                $student = Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                        'student_id_number' => $user->student?->student_id_number ?? 'PENDING_' . Str::random(5),
                        'batch_id' => $batch->id,
                        'specialization_id' => $batch->specialization_id,
                        'current_academic_year' => $batch->current_academic_year ?? 1,
                        'current_semester' => $batch->current_semester ?? 1,
                        'status' => 'نشط',
                    ]
                );
            }
            session()->forget('join_batch_id');
        }

        // Redirect to appropriate dashboard
        return $this->redirectBasedOnRole($user);
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }
}