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
        'day'
    ];
public function teacher() { return $this->belongsTo(Teacher::class); }
public function subject() { return $this->belongsTo(Subject::class); }
public function period()  { return $this->belongsTo(Period::class); }

}
