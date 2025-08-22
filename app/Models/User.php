<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ أضف هذا السطر

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
      public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
      /**
     * التحقق مما إذا كان المستخدم طالبًا.
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * التحقق مما إذا كان المستخدم دكتورًا.
     *
     * @return bool
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * التحقق مما إذا كان المستخدم مديرًا.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
