<?php
    
    namespace App\Http\Controllers\Backend\Profile;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use Auth;
    
class UserLogController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('backend.profile.users_log.index');
    }

    public function getDataUserLog(Request $request)
    {
        $userId = Auth::id();
        
        $postsQuery = Activity::with('causer')
            ->where('causer_id', $userId)
            ->whereIn('log_name', ['login', 'logout']) // Tambahkan klausa whereIn untuk log_name
            ->orderBy('created_at', 'desc');

        $data = $postsQuery->get();


        return \DataTables::of($data) 

        ->addColumn('created_at', function ($data) {
    $label = '';
    if (empty($data->created_at)) {
        $label = '<label class="badge badge-warning">Belum Pernah Login</label>';
    } else {
        $label = '<label class="badge badge-info">' . $data->created_at->diffForHumans() . '</label>';
    }

    // Bungkus dengan div yang text-end agar label rata kanan
    return '<div class="text-end">' . $label . '</div>';
})

        
       
        ->addColumn('description', function ($data) {
            return $data->description;
        })
        ->addColumn('ip', function ($data) {
            return $data->properties['agent']['ip'];
        })
        
        ->addColumn('os', function ($data) {
            return $data->properties['agent']['os'] . ' - ' . $data->properties['agent']['browser'];
        })
        
        ->addColumn('device', function ($data) {
            $x = '';
            
            if ($data->properties['agent']['device'] === 'Desktop') {
                $x .= '<i class="ki-outline ki-screen text-primary me-2"></i>' . $data->properties['agent']['device'];
            } elseif ($data->properties['agent']['device'] === 'Tablet') {
                $x .= '<i class="ki-outline ki-tablet text-success me-2"></i>' . $data->properties['agent']['device'];
            } elseif ($data->properties['agent']['device'] === 'Phone') {
                $x .= '<i class="ki-outline ki-phone text-warning me-2"></i>' . $data->properties['agent']['device'];
            } else {
                $x .= '<i class="ki-outline ki-question-2 text-danger me-2"></i>Unknown';
            }
        
            return $x;
        })
        
        

            ->rawColumns(['created_at', 'ip', 'description', 'browser', 'os', 'device'])
            ->make(true);
    }

    public function getDataUserLogActivity(Request $request)
    {
        $userId = Auth::id();
        
        $postsQuery = Activity::with('causer')
        ->where('causer_id', $userId)
        ->whereNotIn('log_name', ['login', 'logout']) // Tambahkan klausa whereNotIn untuk log_name
        ->orderBy('created_at', 'desc')
        ->take(5);

        $data = $postsQuery->get();



        return \DataTables::of($data) 

        ->addColumn('created_at', function ($data) {
            $x = '';
            if (empty($data->created_at)) {
                $x .= ' <div class="text-end" role="group"><label class="badge badge-warning text-end">Belum Pernah Login</label></div>';
            } else {
                $x .= ' <div class="text-end" role="group"><label class="badge badge-info">' . $data->created_at->format('d-m-Y H:i:s') . '</label></div>';

            }
        
            return $x;
        })
        
       
        ->addColumn('description', function ($data) {
            return $data->description;
        })
        ->addColumn('ip', function ($data) {
            return $data->properties['agent']['ip'];
        })
        

            ->rawColumns(['created_at', 'ip', 'description'])
            ->make(true);
    }

    public function show($id)
    {
        $data = Activity::findOrFail($id);
        return view('backend.profile.users_log.show',compact('data'));
    }
    
    
}