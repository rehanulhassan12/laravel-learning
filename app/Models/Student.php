<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'roll_no',
        'gender',
        'dob',
        'guardian_id',
        'class_id',
        'user_id', // link to User account for login
    ];

    // Relations
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
