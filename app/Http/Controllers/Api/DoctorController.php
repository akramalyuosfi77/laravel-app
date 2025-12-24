<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    // --- جلب كل الدكاترة ---
    public function index(Request $request)
    {
        $doctors = Doctor::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return response()->json($doctors);
    }

    // --- جلب دكتور واحد ---
    public function show($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            return response()->json($doctor);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Doctor not found.'], 404);
        }
    }

    // --- إضافة دكتور جديد ---
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $doctor = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'doctor',
                ]);

                $imagePath = null;
                if ($request->hasFile('profile_image')) {
                    $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                }

                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'profile_image' => $imagePath,
                ]);

                return $doctor;
            });

            return response()->json(['message' => 'Doctor created successfully.', 'doctor' => $doctor], 201);

        } catch (\Exception $e) {
            Log::error('Error creating doctor: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the doctor.'], 500);
        }
    }

    // --- تحديث بيانات الدكتور ---
    public function update(Request $request, $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $user = $doctor->user;

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:8',
                'phone' => 'nullable|string|max:20',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            DB::transaction(function () use ($request, $doctor, $user) {
                // تحديث بيانات المستخدم
                $user->name = $request->name;
                $user->email = $request->email;
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                // تحديث بيانات الدكتور
                $doctor->name = $request->name;
                $doctor->email = $request->email;
                $doctor->phone = $request->phone;

                if ($request->hasFile('profile_image')) {
                    // حذف الصورة القديمة
                    if ($doctor->profile_image) {
                        Storage::disk('public')->delete($doctor->profile_image);
                    }
                    // تخزين الصورة الجديدة
                    $doctor->profile_image = $request->file('profile_image')->store('profile_images', 'public');
                }
                $doctor->save();
            });

            return response()->json(['message' => 'Doctor updated successfully.', 'doctor' => $doctor->fresh()]);

        } catch (\Exception $e) {
            Log::error("Error updating doctor {$id}: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred or doctor not found.'], 500);
        }
    }

    // --- حذف الدكتور ---
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $doctor = Doctor::findOrFail($id);
                // حذف الصورة
                if ($doctor->profile_image) {
                    Storage::disk('public')->delete($doctor->profile_image);
                }
                // حذف المستخدم (سيؤدي إلى حذف الدكتور تلقائياً إذا كان لديك onDelete('cascade'))
                $doctor->user()->delete();
            });

            return response()->json(['message' => 'Doctor deleted successfully.']);

        } catch (\Exception $e) {
            Log::error("Error deleting doctor {$id}: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred or doctor not found.'], 500);
        }
    }
}
