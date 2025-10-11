<?php
    
namespace App\Http\Controllers\Backend\Help;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
    
class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:logactivity-list', ['only' => ['index','getDataLogActivity']]);
        $this->middleware('permission:logactivity-show', ['only' => ['show']]);
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

    public function getDataLogActivity(Request $request)
    {
        $searchValue = $request->search['value'] ?? null;
    
        $postsQuery = Activity::with(['causer:id,name'])
            ->select('id', 'log_name', 'description', 'causer_id', 'created_at')
            ->orderBy('created_at', 'desc');
    
        if (!empty($searchValue)) {
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('log_name', 'LIKE', "%{$searchValue}%")
                      ->orWhere('description', 'LIKE', "%{$searchValue}%");
            });
        }
    
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
    
            ->addColumn('causer_id', function ($data) {
                return '<label class="badge badge-secondary fw-bold">' . $data->causer->name . '</label>';
            })
    
            ->addColumn('log_name', function ($data) {
                return '<a href="' . route('log-activity.show', $data->id) . '" class="badge badge-secondary fw-bold">' . $data->log_name . '</a>';
            })
    
            ->editColumn('created_at', function ($data) {
                return '<div class="text-end"><label class="badge badge-warning fw-bold">' . $data->created_at->format('d-m-Y H:i:s') . '</label></div>';
            })
    
            ->rawColumns(['causer_id', 'log_name', 'created_at'])
            ->make(true);
    }
    

    public function show($id)
    {
        $data = Activity::findOrFail($id);
        return view('backend.help.log_activity.show',compact('data'));
    }
    
    
}