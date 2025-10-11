<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogLastLogin;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogLastLogin::class,
        ],
        
    ];

    public function boot()
    {
        parent::boot();
    }

    
}
