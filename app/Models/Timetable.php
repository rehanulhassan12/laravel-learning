<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
      protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'period_id',
         'school_id',
        'day'
    ];
public function teacher() { return $this->belongsTo(Teacher::class); }
public function subject() { return $this->belongsTo(Subject::class); }
public function period()  { return $this->belongsTo(Period::class); }
public function school()  { return $this->belongsTo(School::class); }

public function classRoom()
{
    return $this->belongsTo(ClassRoom::class, 'class_id');
}


}
