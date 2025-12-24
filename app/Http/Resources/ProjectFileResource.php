<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL; // ✅ 1. إضافة هذا السطر

class ProjectFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // ✅ 2. هذا هو التعديل الأهم
            // سيقوم ببناء الرابط الكامل للملف بشكل صحيح
            'file_path' => URL::to(Storage::url($this->file_path)),

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

            // يمكنك إضافة أي حقول أخرى تحتاجها هنا
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
        ];
    }
}
