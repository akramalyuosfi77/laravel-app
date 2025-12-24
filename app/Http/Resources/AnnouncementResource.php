<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'level' => $this->level, // 'info', 'success', 'warning', 'danger'
            'author' => $this->whenLoaded('user', function () {
                return $this->user->name ?? 'مسؤول النظام';
            }),
            'created_at' => $this->created_at->diffForHumans(), // تنسيق مثل "منذ 5 دقائق"
            'expires_at' => $this->expires_at,
        ];
    }
}
