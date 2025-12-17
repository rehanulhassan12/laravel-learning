<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Models\ClassRoom;
use \Models\School;
use \Models\SchoolGroup;

use App\Policies\SchoolPolicy;
use App\Policies\SchoolGroupPolicy;
use App\Policies\ClassPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [
        School::class => SchoolPolicy::class,
        ClassRoom::class => ClassPolicy::class,
        SchoolGroup::class => SchoolGroupPolicy::class
        

    ];


    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
