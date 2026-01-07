<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_id',
        'yearly_amount',
        'monthly_amount',
        "year"
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
}
