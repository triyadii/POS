<?php

namespace App\Listeners;

use IlluminateAuthEventsLogout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;
use Auth;

class LogoutSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $subject = 'logout';
        $description = ' berhasil Logout';
        //$description = $event->user->name . ' berhasil Logout';


        activity($subject)
            ->by($event->user)
            ->log($description);
    }
}
