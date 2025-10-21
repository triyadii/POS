<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Models\Activity;
use Jenssegers\Agent\Facades\Agent;

use App\Models\SettingApp;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function detectDevice()
    {
        $agent = new \Jenssegers\Agent\Agent();

        if ($agent->isMobile()) {
            return 'Phone';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isDesktop()) {
            return 'Desktop';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Activity::saving(function (Activity $activity) {

            $activity->properties = $activity->properties->put('agent', [
                'ip' => Request::ip(),
                'browser' => Agent::browser(),
                'os' => Agent::platform(),
                'device' => $this->detectDevice(),
                'robot' => Agent::isRobot(),
            ]);
        });

        // Kirim data setting dan activity ke semua view
        View::composer('*', function ($view) {
            $setting = SettingApp::first();
            $view->with('appSetting', $setting);

            $user = Auth::user();
            $activities = [];

            if ($user) {
                $activities = Activity::where('causer_id', $user->id)
                    ->latest()
                    ->limit(10)
                    ->get();
            }

            $view->with('userActivities', $activities);
        });


    }
}
