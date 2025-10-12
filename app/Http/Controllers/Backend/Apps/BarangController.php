<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;
use Validator;
use Illuminate\Support\Str;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:barang-list', ['only' => ['index','getData']]);
        $this->middleware('permission:barang-create', ['only' => ['store']]);
        $this->middleware('permission:barang-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:barang-delete', ['only' => ['destroy']]);
        $this->middleware('permission:barang-massdelete', ['only' => ['massDelete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        return view('backend.apps.barang.index');
    }

    public function getData(Request $request)
    {
        $postsQuery = Barang::orderBy('created_at', 'desc');
        if (!empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $postsQuery->where(function ($query) use ($searchValue) {
                $query->where('kode_barang', 'LIKE', "%{$searchValue}%");
            });
        }
        $data = $postsQuery->select('*');

        return \DataTables::of($data) 
         ->addIndexColumn()

         ->addColumn('action', function($row) {
            $x='';
            if (auth()->user()->can('barang-show') || auth()->user()->can('barang-edit') || auth()->user()->can('barang-delete')) {

                $x.='<div class="dropdown text-end">
                <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                if (auth()->user()->can('barang-show')) {
                    $x.=' <li><a class="dropdown-item btn px-3" href="'.route('barang.show', $row->id).'" >Detail</a></li>';
                }
                if (auth()->user()->can('barang-edit')) {
                    $x.=' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="'.$row->id.'" >Edit</a></li>';
                }
                if (auth()->user()->can('barang-delete')) {
                    $x.=' <li><a class="dropdown-item btn px-3" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                }
                $x .= '</ul></div>';

            }
            return '
            '.$x.'
            ';  
        })


        ->addColumn('nama', function ($row) {
            return '
                <div class="d-flex flex-column">
                    <span class="fw-bold text-gray-800">' . e($row->nama) . '</span>
                    <span class="text-muted fs-7">Kode: ' . e($row->kode_barang) . '</span>
                </div>
            ';
        })


        ->addColumn('kategori_id', function ($row) {
            $namaKategori = $row->kategori->nama ?? '-';
            $hash = substr(md5(strtolower($namaKategori)), 0, 6); // ambil 6 digit pertama hex
            $badgeColor = '#' . $hash;
        
            return '
                <span class="badge fw-semibold" style="background-color:' . $badgeColor . '; color:#fff;">
                    ' . e($namaKategori) . '
                </span>
            ';
        })
        
        
        ->addColumn('brand_id', function ($row) {
            return '
                <div class="d-flex flex-column">
                    <span class="fw-semibold text-gray-800">' . e($row->brand->nama ?? '-') . '</span>
                    <span class="text-muted fs-7">Tipe: ' . e($row->tipe->nama ?? '-') . '</span>
                </div>
            ';
        })


        ->addColumn('stok', function ($row) {
            $stok = $row->stok ?? 0;
            $satuan = $row->satuan->singkatan ?? '-';
        
            return '
                <div class="d-flex flex-column align-items-start">
                    <span class="fw-semibold text-gray-800">' . number_format($stok, 0, ',', '.') . ' ' . e($satuan) . '</span>
                </div>
            ';
        })
        
        ->addColumn('harga_jual', function ($row) {
            $harga = $row->harga_jual ?? 0;
            return '
                <div class="text-end">
                    <span class="fw-bold text-success">Rp ' . number_format($harga, 0, ',', '.') . '</span>
                </div>
            ';
        })
        
        ->addColumn('harga_beli', function ($row) {
            $harga = $row->harga_beli ?? 0;
            return '
                <div class="text-end">
                    <span class="fw-semibold text-danger">Rp ' . number_format($harga, 0, ',', '.') . '</span>
                </div>
            ';
        })
        
        
        

        
           
            ->rawColumns(['action','nama', 'kategori_id', 'brand_id','stok', 'harga_jual', 'harga_beli'])
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request)
     {
         $formattedTime = Carbon::now()->diffForHumans();
     
         // 🧩 Validasi Struktur Repeater
         $validator = Validator::make($request->all(), [
            'kelompok_barang' => 'required|array|min:1',
            'kelompok_barang.*.kategori_id' => 'required|uuid',
            'kelompok_barang.*.brand_id'    => 'required|uuid',
            'kelompok_barang.*.barang'      => 'required|array|min:1',
            'kelompok_barang.*.barang.*.kode' => 'required|string|max:100',
            'kelompok_barang.*.barang.*.nama' => [
                'required',
                'string',
                'max:150',
                // validasi unik hanya berdasarkan brand & kategori
                function ($attribute, $value, $fail) use ($request) {
                    foreach ($request->kelompok_barang as $kelompok) {
                        $exists = \App\Models\Barang::where('nama', $value)
                            ->where('brand_id', $kelompok['brand_id'])
                            ->where('kategori_id', $kelompok['kategori_id'])
                            ->exists();
                        if ($exists) {
                            $fail("Nama barang '{$value}' sudah ada pada brand dan kategori tersebut.");
                        }
                    }
                },
            ],
            'kelompok_barang.*.barang.*.tipe_id' => 'required|uuid',
            'kelompok_barang.*.barang.*.satuan_id' => 'required|uuid',
            'kelompok_barang.*.barang.*.harga_beli' => 'required|numeric|min:0',
            'kelompok_barang.*.barang.*.harga_jual' => 'required|numeric|min:0',
        ], [
            'kelompok_barang.required' => 'Minimal 1 kelompok barang harus diisi.',
            'kelompok_barang.*.kategori_id.required' => 'Kategori wajib dipilih.',
            'kelompok_barang.*.brand_id.required' => 'Brand wajib dipilih.',
            'kelompok_barang.*.barang.*.nama.required' => 'Nama Item wajib diisi.',
            'kelompok_barang.*.barang.*.tipe_id.required' => 'Tipe wajib dipilih.',
            'kelompok_barang.*.barang.*.satuan_id.required' => 'Satuan wajib dipilih.',
            'kelompok_barang.*.barang.*.harga_beli.required' => 'Harga beli wajib diisi.',
            'kelompok_barang.*.barang.*.harga_jual.required' => 'Harga jual wajib diisi.',
        ]);
        
     
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()]);
         }
     
         try {
             DB::beginTransaction();
     
             $savedCount = 0;
     
             // Loop kelompok (kategori + brand)
             foreach ($request->kelompok_barang as $kelompok) {
                 $kategoriId = $kelompok['kategori_id'];
                 $brandId = $kelompok['brand_id'];
     
                 // Loop inner barang
                 foreach ($kelompok['barang'] as $item) {
                     Barang::create([
                         'id'          => (string) Str::uuid(),
                         'kode_barang' => $item['kode'],
                         'nama'        => $item['nama'],
                         'kategori_id' => $kategoriId,
                         'brand_id'    => $brandId,
                         'tipe_id'     => $item['tipe_id'],
                         'satuan_id'   => $item['satuan_id'],
                         'stok'        => 0,
                         'harga_beli'  => $item['harga_beli'],
                         'harga_jual'  => $item['harga_jual'],
                     ]);
     
                     $savedCount++;
                 }
             }
     
             // ✅ Activity log (Spatie)
             activity('tambah barang')
                 ->causedBy(Auth::user() ?? null)
                 ->withProperties([
                     'jumlah_data' => $savedCount,
                     'input' => $request->kelompok_barang
                 ])
                 ->log('Menambahkan ' . $savedCount . ' data barang baru');
     
             DB::commit();
     
             return response()->json([
                 'success' => 'Berhasil menyimpan ' . $savedCount . ' data barang.',
                 'time'    => $formattedTime,
                 'judul'   => 'Berhasil',
             ]);
     
         } catch (\Exception $e) {
             DB::rollBack();
             return response()->json([
                 'error'        => 'Terjadi kesalahan di aplikasi, hubungi developer.',
                 'judul'        => 'Aplikasi Error',
                 'time'         => $formattedTime,
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
        $data = Barang::findOrFail($id);
        $html = view('backend.apps.barang.edit', [
            'data' => $data,
            'kategoriSelected' => $data->findOrFail($id)->kategori,
            'brandSelected' => $data->findOrFail($id)->brand,
            'tipeSelected' => $data->findOrFail($id)->tipe,
            'satuanSelected' => $data->findOrFail($id)->satuan,
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
    $validator = \Validator::make($request->all(), [
        'kode_barang' => 'required|string|max:100|unique:barang,kode_barang,' . $id . ',id',
        'nama'        => 'required|string|max:150|unique:barang,nama,' . $id . ',id',
        'kategori_id' => 'required|uuid',
        'brand_id'    => 'required|uuid',
        'tipe_id'     => 'required|uuid',
        'satuan_id'   => 'required|uuid',
        'stok'        => 'nullable|numeric|min:0',
        'harga_beli'  => 'required|numeric|min:0',
        'harga_jual'  => 'required|numeric|min:0',
    ], [
        'kode_barang.required' => 'Kode Barang wajib diisi',
        'kode_barang.unique'   => 'Kode Barang sudah digunakan oleh barang lain',
        'nama.required'        => 'Nama Barang wajib diisi',
        'nama.unique'          => 'Nama Barang sudah digunakan oleh barang lain',
        'kategori_id.required' => 'Kategori wajib dipilih',
        'brand_id.required'    => 'Brand wajib dipilih',
        'tipe_id.required'     => 'Tipe wajib dipilih',
        'satuan_id.required'   => 'Satuan wajib dipilih',
        'harga_beli.required'  => 'Harga beli wajib diisi',
        'harga_jual.required'  => 'Harga jual wajib diisi',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    try {
        \DB::beginTransaction();

        // 🔍 Ambil data lama
        $data = \App\Models\Barang::findOrFail($id);
        $oldData = $data->getOriginal();

        // 🔁 Update data barang
        $data->update([
            'kode_barang' => $request->input('kode_barang'),
            'nama'        => $request->input('nama'),
            'kategori_id' => $request->input('kategori_id'),
            'brand_id'    => $request->input('brand_id'),
            'tipe_id'     => $request->input('tipe_id'),
            'satuan_id'   => $request->input('satuan_id'),
            'stok'        => $request->input('stok') ?? 0,
            'harga_beli'  => $request->input('harga_beli'),
            'harga_jual'  => $request->input('harga_jual'),
        ]);

        // 🧠 Catat perubahan
        $changes = [
            'attributes' => $data,
            'old'        => $oldData,
        ];

        activity('edit barang')
            ->causedBy(\Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties($changes)
            ->log('Mengubah data Barang: ' . $data->nama);

        \DB::commit();

        return response()->json([
            'success' => 'Data ' . $data->nama . ' berhasil diperbarui.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();

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

        $data = Barang::findOrFail($id);
        $data->delete();

        // 🧠 Log aktivitas
        activity('hapus barang')
            ->causedBy(Auth::user() ?? null)
            ->performedOn($data)
            ->withProperties(['attributes' => $data])
            ->log('Menghapus Barang: ' . $data->nama);

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
        $records = Barang::whereIn('id', $ids)->get();

        // Hapus sekaligus
        Barang::whereIn('id', $ids)->delete();

        // Commit dulu sebelum log (supaya pasti sudah terhapus)
        \DB::commit();

        // Log setiap data di luar transaksi (aman & non-blocking)
        foreach ($records as $record) {
            activity('mass delete barang')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties(['attributes' => $record->toArray()])
                ->log('Menghapus Barang: ' . $record->nama);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data barang berhasil dihapus.',
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
            $barang = [];
    
            if ($request->has('q')) {
                $search = $request->q;
                $barang = Barang::select("id", "nama", "kode_barang")
                ->where(function($query) use ($search) {
                    $query->where('kode_barang', 'LIKE', "%{$search}%")
                          ->orWhere('nama', 'LIKE', "%{$search}%");
                })
                ->limit(30)
                ->get();
            } else {
                $barang = Barang::limit(30)->get();
            }
            return response()->json($barang);
        }


}
