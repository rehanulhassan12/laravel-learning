<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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

    // Relationships

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function screens()
    {
        $roleIds = $this->roles()->select('roles.id')->pluck('id')->toArray();

        return Screen::whereHas('roles', function ($q) use ($roleIds) {
            $q->whereIn('roles.id', $roleIds);
        });
    }

    // Helper methods

    public function hasRole($roleName)
    {
        return $this->roles->pluck('name')->contains($roleName);
    }

    public function canAccessScreen(string $screen): bool
    {
        return $this->roles()
            ->whereHas('screens', fn($q) => $q->where('name', $screen))
            ->exists();
    }

    public function canAccessScreens($screenRoute)
    {
        return $this->screens()->where('route_name', $screenRoute)->exists();
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
}
