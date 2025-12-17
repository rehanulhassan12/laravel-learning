<?php

namespace App\Listeners;

use App\Events\SchoolGroupCreated;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendSchoolGroupCreatedNotification implements ShouldQueue
{
    

    /**
     * Handle the event.
     */
    public function handle(SchoolGroupCreated $event): void
    {
        \Log::info('SchoolGroupCreated: ' . $event->school_group->name);

    }
}
