<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;

use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:customer-list', ['only' => ['index','getData']]);
        $this->middleware('permission:customer-create', ['only' => ['store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
        $this->middleware('permission:customer-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.master.customer.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = Customer::orderBy('created_at', 'desc');
        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('nama', 'LIKE', "%{$searchValue}%");
            });
        }
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
         ->addIndexColumn()

         


        ->addColumn('action', function($data) {
            return '
            <div class="text-end">
                <a href="#" 
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-show-customer" 
                    data-id="'.$data->id.'" >
                    <i class="ki-outline ki-eye fs-2"></i>
                </a>
        
                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                    id="getEditRowData" data-id="'.$data->id.'">
                    <i class="ki-outline ki-pencil fs-2"></i>
                </a>
                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" 
                   data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">
                    <i class="ki-outline ki-trash fs-2"></i>
                </a>
            </div>';
        })

        
           
            ->rawColumns(['action'])
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function show($id)
{
    $data = Customer::findOrFail($id);
    return view('backend.master.customer.show', compact('data'));
}



public function store(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    // 🧩 Validasi input
    $validator = Validator::make($request->all(), [
        'nama'   => 'required|string|max:150',
        'no_wa'  => 'required|string|max:20|unique:customers,no_wa',
    ], [
        'nama.required'  => 'Nama Customer wajib diisi.',
        'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
        'no_wa.unique'   => 'Nomor WhatsApp sudah terdaftar.',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        DB::beginTransaction();

        // ✅ Simpan data customer (UUID otomatis dari model)
        $data = Customer::create([
            'nama'      => $request->input('nama'),
            'no_wa'     => $request->input('no_wa'),
        ]);

        // 🧠 Catat log aktivitas (jika pakai spatie/activitylog)
        $changes = ['attributes' => $data];

        activity('tambah customer')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Menambahkan Customer: ' . $data->nama);

        DB::commit();

        return response()->json([
            'success' => 'Data ' . $data->nama . ' berhasil disimpan.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
            'time'         => $formattedTime,
            'judul'        => 'Aplikasi Error',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}

    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        $html = view('backend.master.customer.edit', [
            'data' => $data 
        ])->render();

        return response()->json(['html' => $html]);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formattedTime = Carbon::now()->diffForHumans();
    
        // 🧩 Validasi input
        $validator = Validator::make($request->all(), [
            'nama'   => 'required|string|max:150',
            'no_wa'  => 'required|string|max:20|unique:customers,no_wa,' . $id . ',id',
        ], [
            'nama.required'  => 'Nama Customer wajib diisi.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.unique'   => 'Nomor WhatsApp sudah digunakan oleh customer lain.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    
        try {
            DB::beginTransaction();
    
            // 🔍 Ambil data lama
            $data = Customer::findOrFail($id);
            $oldData = $data->getOriginal();
    
            // 🧹 Bersihkan karakter non-angka dari no_wa (opsional tapi disarankan)
            $cleanNoWa = preg_replace('/\D/', '', $request->input('no_wa'));
    
            // 🔁 Update data customer
            $data->update([
                'nama'  => $request->input('nama'),
                'no_wa' => $cleanNoWa,
            ]);
    
            // 🧠 Catat perubahan
            $changes = [
                'attributes' => $data,
                'old'        => $oldData,
            ];
    
            activity('edit customer')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($data)
                ->withProperties($changes)
                ->log('Mengubah data Customer: ' . $data->nama);
    
            DB::commit();
    
            return response()->json([
                'success' => 'Data ' . $data->nama . ' berhasil diperbarui.',
                'time'    => $formattedTime,
                'judul'   => 'Berhasil',
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'error'        => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
                'time'         => $formattedTime,
                'judul'        => 'Aplikasi Error',
                'errorMessage' => $e->getMessage(),
            ]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $formattedTime = Carbon::now()->diffForHumans();

    try {
        \DB::beginTransaction();

        $data = Customer::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus customer')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus Customer: ' . $data->nama);

        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $data->nama . ' berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error'        => 'Data gagal dihapus.',
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}


public function massDelete(Request $request)
{
    $formattedTime = Carbon::now()->diffForHumans();

    try {
        \DB::beginTransaction();

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada data yang dipilih untuk dihapus.',
            ]);
        }

        // Ambil semua data sebelum dihapus (untuk log)
        $records = Customer::whereIn('id', $ids)->get();

        // Hapus sekaligus
        Customer::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete customer')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Customer: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data customer berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan saat menghapus data.',
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}



    public function select(Request $request)
        {
            $customer = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $customer = Customer::select("id", "nama")
                    ->Where('nama', 'LIKE', "%$search%")
                    ->get();
            } else {
                $customer = Customer::limit(30)->get();
            }
            return response()->json($customer);
        }


}
