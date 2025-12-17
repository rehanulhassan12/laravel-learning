<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\SchoolGroup;


class SchoolGroupCreated
{
    use Dispatchable, SerializesModels;

    public $school_group;
   
    public function __construct( SchoolGroup $school_group)
    {
        $this->school_group = $school_group;
    }

   
}
