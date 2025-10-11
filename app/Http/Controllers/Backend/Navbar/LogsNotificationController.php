<?php
    
namespace App\Http\Controllers\Backend\Navbar;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
    
class LogsNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('backend.help.log_activity.index');
    }

    public function getUserShowLogActivity(Request $request, $id)
    {
        
        $postsQuery = Activity::with('causer')
        ->where('causer_id', $id)
        ->orderBy('id', 'desc')
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
        return view('backend.help.log_activity.show',compact('data'));
    }
    
    
}