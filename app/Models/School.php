<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['school_group_id', 'name', 'address'];

    public function group()
    {
        return $this->belongsTo(SchoolGroup::class, 'school_group_id');
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function attendenceClasses($session = null, $section = null)
    {
        $query = $this->classes();

        if ($session) {
            $query->where('session_year', $session);
        }

        if ($section) {
            $query->where('section', $section);
        }

        return $query->get();
    }
}
