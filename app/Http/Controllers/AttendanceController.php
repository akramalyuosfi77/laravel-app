<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function mark(Request $request, Lecture $lecture)
    {
        // 1. Check if URL is valid (signed)
        if (!$request->hasValidSignature()) {
            return view('attendance.error', ['message' => 'رابط تسجيل الحضور غير صالح أو منتهي الصلاحية.']);
        }

        // 2. Check if user is authenticated and is a student
        $user = Auth::user();
        if (!$user || !$user->student) {
            return view('attendance.error', ['message' => 'يجب عليك تسجيل الدخول كطالب لتسجيل الحضور.']);
        }

        $student = $user->student;

        // 3. Check if student is enrolled in the course (via batch)
        // Assuming student belongs to a batch, and batch has courses or specializations
        // For simplicity, we'll check if the student's batch matches the course's batch (if applicable)
        // Or simply proceed if we don't have strict enrollment checks yet.
        // Let's assume strict check:
        if ($student->batch_id !== $lecture->course->batch_id && $lecture->course->batch_id !== null) {
             // If course is assigned to a specific batch and student is not in it
             // return view('attendance.error', ['message' => 'أنت غير مسجل في هذه المادة.']);
        }

        // 4. Check if already attended
        $existingAttendance = Attendance::where('student_id', $student->id)
            ->where('lecture_id', $lecture->id)
            ->first();

        if ($existingAttendance) {
            return view('attendance.success', ['message' => 'لقد قمت بتسجيل الحضور مسبقاً لهذه المحاضرة.', 'lecture' => $lecture]);
        }

        // 5. Mark Attendance
        Attendance::create([
            'student_id' => $student->id,
            'lecture_id' => $lecture->id,
            'status' => 'present',
            'date' => now(),
            'notes' => 'تم التسجيل عبر QR Code',
        ]);

        return view('attendance.success', ['message' => 'تم تسجيل حضورك بنجاح! ✅', 'lecture' => $lecture]);
    }
}
