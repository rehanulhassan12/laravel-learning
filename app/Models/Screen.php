<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasFactory;

     protected $fillable = ['name','route_name','icon','parent_id'];

    public function parent() {
        return $this->belongsTo(Screen::class,'parent_id');
    }

  public function children()
{
    return $this->hasMany(Screen::class, 'parent_id')->with('children');
}

    // Roles that have this screen
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_screen');
    }
public function childrenRecursive()
{
    return $this->hasMany(Screen::class, 'parent_id')->with('childrenRecursive');
}


}
