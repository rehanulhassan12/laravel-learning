<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Teacher extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id', 'name', 'phone', 'gender', 'specialization', 'dob','school_id'
    ];
       public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

    public function school() {
    return $this->belongsTo(School::class);
}


    public function timetables() {
    return $this->hasMany(Timetable::class);
}

}
