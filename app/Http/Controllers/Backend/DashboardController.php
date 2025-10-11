<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Log;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.dashboard.index');
    }


    public function getLogActivities()
{
    $activities = Activity::with('causer')
        ->orderBy('id', 'desc')
        ->limit(10) // Ambil 10 aktivitas terbaru
        ->get();

    // Hitung jumlah aktivitas dalam bulan ini
    $monthlyActivityCount = Activity::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count();

    return response()->json([
        'activities' => $activities,
        'monthly_count' => $monthlyActivityCount
    ]);
}


}
