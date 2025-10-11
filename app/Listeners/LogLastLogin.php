<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogLastLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->last_login_at = now();
        $user->last_login_ip = Request::ip();
        $user->save();
    }
}
