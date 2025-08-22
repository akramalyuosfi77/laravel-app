<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionReply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
    ];

    /**
     * علاقة لجلب النقاش الذي ينتمي إليه هذا الرد.
     */
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * علاقة لجلب المستخدم الذي قام بالرد (سواء كان طالبًا أو دكتورًا).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
