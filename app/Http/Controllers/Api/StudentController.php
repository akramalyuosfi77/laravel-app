<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // --- جلب كل الطلاب مع الفلاتر ---
    public function index(Request $request)
    {
        $students = Student::with(['batch.specialization.department']) // جلب العلاقات المهمة
            ->when($request->search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('student_id_number', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->batch_id, fn($q, $val) => $q->where('batch_id', $val))
            ->when($request->academic_year, fn($q, $val) => $q->where('current_academic_year', $val))
            ->when($request->semester, fn($q, $val) => $q->where('current_semester', $val))
            ->when($request->status, fn($q, $val) => $q->where('status', $val))
            ->latest('created_at')
            ->get();

        return response()->json($students);
    }

    // --- جلب طالب واحد ---
    public function show($id)
    {
        try {
            $student = Student::with(['batch.specialization.department'])->findOrFail($id);
            return response()->json($student);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Student not found.'], 404);
        }
    }

    // --- إضافة طالب جديد ---
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'student_id_number' => 'required|string|max:255|unique:students,student_id_number',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:ذكر,أنثى',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'batch_id' => 'required|exists:batches,id',
            'status' => 'required|string|in:نشط,متخرج,موقوف,منسحب',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $student = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'student',
                ]);

                $batch = Batch::find($request->batch_id);

                $imagePath = null;
                if ($request->hasFile('profile_image')) {
                    $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                }

                $student = Student::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'student_id_number' => $request->student_id_number,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'date_of_birth' => $request->date_of_birth,
                    'address' => $request->address,
                    'batch_id' => $request->batch_id,
                    'current_academic_year' => $batch->academic_year,
                    'current_semester' => $batch->semester,
                    'status' => $request->status,
                    'profile_image' => $imagePath,
                ]);

                return $student;
            });

            return response()->json(['message' => 'Student created successfully.', 'student' => $student], 201);

        } catch (\Exception $e) {
            Log::error('Error creating student: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the student.'], 500);
        }
    }

    // --- تحديث بيانات الطالب ---
    public function update(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            $user = $student->user;

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'student_id_number' => ['required', 'string', 'max:255', Rule::unique('students')->ignore($student->id)],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:8',
                'phone' => 'nullable|string|max:20',
                'gender' => 'nullable|string|in:ذكر,أنثى',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'batch_id' => 'required|exists:batches,id',
                'status' => 'required|string|in:نشط,متخرج,موقوف,منسحب',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            DB::transaction(function () use ($request, $student, $user) {
                $user->name = $request->name;
                $user->email = $request->email;
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                $batch = Batch::find($request->batch_id);

                $student->name = $request->name;
                $student->student_id_number = $request->student_id_number;
                $student->email = $request->email;
                $student->phone = $request->phone;
                $student->gender = $request->gender;
                $student->date_of_birth = $request->date_of_birth;
                $student->address = $request->address;
                $student->batch_id = $request->batch_id;
                $student->current_academic_year = $batch->academic_year;
                $student->current_semester = $batch->semester;
                $student->status = $request->status;

                if ($request->hasFile('profile_image')) {
                    if ($student->profile_image) {
                        Storage::disk('public')->delete($student->profile_image);
                    }
                    $student->profile_image = $request->file('profile_image')->store('profile_images', 'public');
                }
                $student->save();
            });

            return response()->json(['message' => 'Student updated successfully.', 'student' => $student->fresh()->load('batch.specialization.department')]);

        } catch (\Exception $e) {
            Log::error("Error updating student {$id}: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred or student not found.'], 500);
        }
    }

    // --- حذف الطالب ---
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $student = Student::findOrFail($id);
                if ($student->profile_image) {
                    Storage::disk('public')->delete($student->profile_image);
                }
                $student->user()->delete();
            });

            return response()->json(['message' => 'Student deleted successfully.']);

        } catch (\Exception $e) {
            Log::error("Error deleting student {$id}: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred or student not found.'], 500);
        }
    }
}
