<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{

     protected $table = 'classes';
    use HasFactory;

    protected $fillable = [
        'name',
        'school_id',
        'section',
        'session_year',

    ];

       public function school()
    {
        return $this->belongsTo(School::class);
    }
}
