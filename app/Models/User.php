<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    public function roles()
{
    return $this->belongsToMany(Role::class, 'role_user');
}


// Helper method to check if user has a role
public function hasRole($roleName)
{
    return $this->roles->pluck('name')->contains($roleName);
}

// Helper method to check if user has access to a screen
public function canAccessScreen(string $screen): bool
{
    return $this->roles()
        ->whereHas('screens', fn($q) => $q->where('name', $screen))
        ->exists();
}
public function firstAccessibleScreen()
{
    return $this->roles()
                ->with('screens')
                ->get()
                ->pluck('screens')
                ->flatten()
                ->first()?->name ?? '/';
}


public function isAdmin(): bool
{
    return $this->roles()->where('name', 'admin')->exists();
}

public function student()
{
    return $this->hasOne(Student::class);
}


}
