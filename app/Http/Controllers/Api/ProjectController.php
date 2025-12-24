<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * عرض قائمة المشاريع مع دعم الفلاتر والبحث.
     */
    public function index(Request $request)
    {
        $query = Project::with([
            'creatorStudent',
            'students',
            'batch',
            'specialization.department',
            'course',
            'doctor',
            'files',
            'likes',
            'comments.student'
        ]);

        // --- تطبيق الفلاتر والبحث ---
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('creatorStudent', fn($sq) => $sq->where('name', 'like', '%' . $search . '%'));
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        // يمكنك إضافة باقي الفلاتر هنا بنفس الطريقة

        $projects = $query->latest()->get();

        // --- [السر هنا] ---
        // بعد جلب كل المشاريع، نمر على كل مشروع
        // ونطلب من كل ملف فيه أن يقوم بإضافة حقل 'file_url'
        $projects->each(function ($project) {
            $project->files->each(function ($file) {
                // هذا السطر يستدعي دالة getFileUrlAttribute() التي أنشأناها
                $file->append('file_url');
            });
        });

        return response()->json($projects);
    }

    /**
     * تحديث حالة المشروع.
     */
    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        try {
            $project->update($validatedData);
            return response()->json(['message' => 'تم تحديث حالة المشروع بنجاح.']);
        } catch (\Exception $e) {
            Log::error('Error updating project status via API: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء تحديث الحالة.'], 500);
        }
    }

    /**
     * حذف مشروع.
     */
    public function destroy(Project $project)
    {
        try {
            DB::transaction(function () use ($project) {
                $project->load('files');
                foreach ($project->files as $file) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $project->delete();
            });
            return response()->json(['message' => 'تم حذف المشروع وكل ملفاته بنجاح.']);
        } catch (\Exception $e) {
            Log::error('Error deleting project via API: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء حذف المشروع.'], 500);
        }
    }
}
