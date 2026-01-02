<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
     protected $fillable = ['name'];
      public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
 public function classes()
{
    return $this->belongsToMany(ClassRoom::class, 'class_subject', 'subject_id', 'class_id');
}


}
