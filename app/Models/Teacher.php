<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Teacher extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id', 'name', 'phone', 'gender', 'specialization', 'dob'
    ];
       public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
