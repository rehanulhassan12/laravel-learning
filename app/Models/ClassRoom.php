<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'school_id',
        'section',
        'session_year',
    ];

    public static function getSessions($classId)
    {
        return self::where('id', $classId)
            ->distinct()
            ->pluck('session_year');
    }



    public function subjects()
{
    return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id');
}



    public static function getSections($classId, $session = null)
    {
        $query = self::where('id', $classId);

        if ($session) {
            $query->where('session_year', $session);
        }

        return $query->pluck('section');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function attendences()
    {
        return $this->hasMany(Attendence::class, 'class_id');
    }
}
