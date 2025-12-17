<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Users assigned to this role
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Screens assigned to this role
    public function screens()
    {
        return $this->belongsToMany(Screen::class, 'role_screen');
    }
}
