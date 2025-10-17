<?php

namespace App\Http\Controllers\Backend\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DataTables;
use Auth;
use Validator;
use Illuminate\Support\Str;


use App\Models\PengeluaranDetail;



class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:pengeluaran-list', ['only' => ['index', 'getData']]);
        $this->middleware('permission:pengeluaran-create', ['only' => ['store']]);
        $this->middleware('permission:pengeluaran-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pengeluaran-delete', ['only' => ['destroy']]);
        $this->middleware('permission:pengeluaran-massdelete', ['only' => ['massDelete']]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('backend.apps.pengeluaran.index');
    }

    public function show($id)
{
    $data = Pengeluaran::with(['details.kategori'])->findOrFail($id);
    return view('backend.apps.pengeluaran.show', compact('data'));
}


    
   

    public function getData(Request $request)
    {
        $postsQuery = Pengeluaran::withCount('details')->orderBy('tanggal', 'desc');
        if (!empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'LIKE', "%{$search}%")
                  ->orWhere('catatan', 'LIKE', "%{$search}%");
            });
        }

        
        
        $data = $postsQuery;

        return \DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                $x = '';
                if (auth()->user()->can('pengeluaran-show') || auth()->user()->can('pengeluaran-edit') || auth()->user()->can('pengeluaran-delete')) {

                    $x .= '<div class="dropdown text-end">
                <button class="btn btn-sm btn-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">';
                    if (auth()->user()->can('pengeluaran-show')) {
                        $x .= ' <li><a class="dropdown-item btn px-3" href="' . route('pengeluaran.show', $row->id) . '" >Detail</a></li>';
                    }
                    if (auth()->user()->can('pengeluaran-edit')) {
                        $x .= ' <li><a class="dropdown-item btn px-3" id="getEditRowData" data-id="' . $row->id . '" >Edit</a></li>';
                    }
                    if (auth()->user()->can('pengeluaran-delete')) {
                        $x .= ' <li><a class="dropdown-item btn px-3" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#Modal_Hapus_Data" id="getDeleteId">Hapus</a></li>';
                    }
                    $x .= '</ul></div>';
                }
                return '
            ' . $x . '
            ';
            })


           // 🧮 Jumlah item (pakai relasi count)
           ->addColumn('jumlah_item', function ($row) {
            $count = $row->details_count ?? 0;
            return '
                <div class="text-end">
                    <span class="badge badge-light-primary">
                        ' . $count . ' Item
                    </span>
                </div>
            ';
        })

        // 💰 Total dengan format rupiah + badge
        ->addColumn('total', function ($row) {
            return '
                <div class="text-end">
                    <span class="fw-semibold badge badge-secondary">
                        Rp ' . number_format($row->total ?? 0, 0, ',', '.') . '
                    </span>
                </div>
            ';
        })
            
            


            

            ->rawColumns(['action','total','jumlah_item'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $formattedTime = Carbon::now()->diffForHumans();

        // 🧩 Validasi input utama & repeater
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:255',
            'detail_pengeluaran' => 'required|array|min:1',
            'detail_pengeluaran.*.nama' => 'required|string|max:150',
            'detail_pengeluaran.*.kategori_pengeluaran_id' => 'nullable|uuid|exists:kategori_pengeluaran,id',
            'detail_pengeluaran.*.jumlah' => 'required|string',
            'detail_pengeluaran.*.keterangan' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'detail_pengeluaran.required' => 'Minimal 1 item pengeluaran harus diisi',
            'detail_pengeluaran.*.nama.required' => 'Nama item wajib diisi',
            'detail_pengeluaran.*.jumlah.required' => 'Jumlah wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            // ✅ Generate kode transaksi unik
            $tanggalNow = Carbon::parse($request->tanggal)->format('Ymd');
            $prefix = 'PGL-' . Carbon::parse($request->tanggal)->format('Ymd') . '-';

            $lastKode = Pengeluaran::whereDate('tanggal', Carbon::parse($request->tanggal))
                ->where('kode_transaksi', 'LIKE', $prefix . '%')
                ->orderBy('kode_transaksi', 'desc')
                ->value('kode_transaksi');

            if ($lastKode) {
                $lastNumber = (int) substr($lastKode, -3);
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            $kodeTransaksi = $prefix . $newNumber;

            // ✅ Hitung total dari repeater
            $total = 0;
            foreach ($request->detail_pengeluaran as $item) {
                $jumlah = (int) str_replace(['Rp', '.', ' '], '', $item['jumlah']);
                $total += $jumlah;
            }

            // ✅ Simpan data utama
            $pengeluaran = Pengeluaran::create([
                'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                'kode_transaksi' => $kodeTransaksi,
                'catatan' => $request->catatan,
                'total' => $total,
            ]);

            // ✅ Simpan detail repeater
            foreach ($request->detail_pengeluaran as $item) {
                $jumlah = (int) str_replace(['Rp', '.', ' '], '', $item['jumlah']);

                PengeluaranDetail::create([
                    'pengeluaran_id' => $pengeluaran->id,
                    'nama' => $item['nama'],
                    'kategori_pengeluaran_id' => $item['kategori_pengeluaran_id'] ?? null,
                    'jumlah' => $jumlah,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }

            // 🧠 Log aktivitas (jika pakai Spatie)
            $changes = ['attributes' => $pengeluaran->load('details')];

            activity('tambah pengeluaran')
                ->causedBy(Auth::user() ?? null)
                ->performedOn($pengeluaran)
                ->withProperties($changes)
                ->log('Menambahkan Pengeluaran: ' . $kodeTransaksi);

            DB::commit();

            return response()->json([
                'success' => 'Data pengeluaran berhasil disimpan.',
                'kode_transaksi' => $kodeTransaksi,
                'total' => number_format($total, 0, ',', '.'),
                'time' => $formattedTime,
                'judul' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Terjadi kesalahan di aplikasi, hubungi Developer.',
                'time' => $formattedTime,
                'judul' => 'Aplikasi Error',
                'errorMessage' => $e->getMessage(),
            ]);
        }
    }
   

    public function edit($id)
        {
            $data = Pengeluaran::with(['details.kategori'])->findOrFail($id);

            $html = view('backend.apps.pengeluaran.edit', [
                'data' => $data,
            ])->render();

            return response()->json(['html' => $html]);
        }


        public function update(Request $request, $id)
        {
            $formattedTime = \Carbon\Carbon::now()->diffForHumans();
        
            $validator = \Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'catatan' => 'nullable|string|max:255',
                'detail_pengeluaran' => 'required|array|min:1',
                'detail_pengeluaran.*.nama' => 'required|string|max:150',
                'detail_pengeluaran.*.kategori_pengeluaran_id' => 'nullable|uuid|exists:kategori_pengeluaran,id',
                'detail_pengeluaran.*.jumlah' => 'required|string',
                'detail_pengeluaran.*.keterangan' => 'nullable|string|max:255',
            ], [
                'tanggal.required' => 'Tanggal wajib diisi',
                'detail_pengeluaran.required' => 'Minimal 1 item pengeluaran harus diisi',
                'detail_pengeluaran.*.nama.required' => 'Nama item wajib diisi',
                'detail_pengeluaran.*.jumlah.required' => 'Jumlah wajib diisi',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
        
            try {
                \DB::beginTransaction();
        
                $pengeluaran = \App\Models\Pengeluaran::findOrFail($id);
                $oldData = $pengeluaran->getOriginal();
        
                // Hitung total baru
                $total = 0;
                foreach ($request->detail_pengeluaran as $item) {
                    $total += (int) str_replace(['Rp', '.', ' '], '', $item['jumlah']);
                }
        
                // Update data utama
                $pengeluaran->update([
                    'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                    'catatan' => $request->catatan,
                    'total'   => $total,
                ]);
        
                // Hapus semua detail lama & simpan ulang
                $pengeluaran->details()->delete();
        
                foreach ($request->detail_pengeluaran as $item) {
                    $jumlah = (int) str_replace(['Rp', '.', ' '], '', $item['jumlah']);
        
                    \App\Models\PengeluaranDetail::create([
                        'id' => (string) \Str::uuid(),
                        'pengeluaran_id' => $pengeluaran->id,
                        'nama' => $item['nama'],
                        'kategori_pengeluaran_id' => $item['kategori_pengeluaran_id'] ?? null,
                        'jumlah' => $jumlah,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }
        
                // Log aktivitas
                $changes = [
                    'attributes' => $pengeluaran->load('details'),
                    'old' => $oldData,
                ];
        
                activity('edit pengeluaran')
                    ->causedBy(\Auth::user() ?? null)
                    ->performedOn($pengeluaran)
                    ->withProperties($changes)
                    ->log('Mengubah data Pengeluaran: ' . $pengeluaran->kode_transaksi);
        
                \DB::commit();
        
                return response()->json([
                    'success' => 'Data pengeluaran ' . $pengeluaran->kode_transaksi . ' berhasil diperbarui.',
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


        public function destroy($id)
        {
            $formattedTime = \Carbon\Carbon::now()->diffForHumans();
        
            try {
                \DB::beginTransaction();
        
                $data = \App\Models\Pengeluaran::with('details')->findOrFail($id);
        
                // Simpan info untuk log sebelum dihapus
                $kodeTransaksi = $data->kode_transaksi;
                $tanggal = $data->tanggal;
        
                // Jika belum cascade di migration, hapus manual:
                $data->details()->delete();
        
                $data->delete();
        
                // 🧠 Log aktivitas
                activity('hapus pengeluaran')
                    ->causedBy(\Auth::user() ?? null)
                    ->performedOn($data)
                    ->withProperties([
                        'kode_transaksi' => $kodeTransaksi,
                        'tanggal' => $tanggal,
                        'total' => $data->total,
                    ])
                    ->log('Menghapus Pengeluaran: ' . $kodeTransaksi);
        
                \DB::commit();
        
                return response()->json([
                    'success' => 'Data Pengeluaran ' . $kodeTransaksi . ' berhasil dihapus.',
                    'time'    => $formattedTime,
                    'judul'   => 'Berhasil',
                ]);
            } catch (\Exception $e) {
                \DB::rollBack();
        
                return response()->json([
                    'error'        => 'Data gagal dihapus. Hubungi developer.',
                    'time'         => $formattedTime,
                    'judul'        => 'Gagal',
                    'errorMessage' => $e->getMessage(),
                ]);
            }
        }

        

        public function massDelete(Request $request)
{
    $formattedTime = \Carbon\Carbon::now()->diffForHumans();

    try {
        \DB::beginTransaction();

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada data yang dipilih untuk dihapus.',
            ]);
        }

        // Ambil semua data untuk keperluan log sebelum dihapus
        $records = \App\Models\Pengeluaran::with('details')->whereIn('id', $ids)->get();

        // Jika belum pakai cascade delete di migration, hapus detail manual
        foreach ($records as $record) {
            $record->details()->delete();
        }

        // Hapus data utama pengeluaran
        \App\Models\Pengeluaran::whereIn('id', $ids)->delete();

        \DB::commit();

        // Log aktivitas di luar transaksi agar non-blocking
        foreach ($records as $record) {
            activity('mass delete pengeluaran')
                ->causedBy(\Auth::user() ?? null)
                ->performedOn($record)
                ->withProperties([
                    'kode_transaksi' => $record->kode_transaksi,
                    'tanggal'        => $record->tanggal,
                    'total'          => $record->total,
                ])
                ->log('Menghapus Pengeluaran: ' . $record->kode_transaksi);
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($ids) . ' data pengeluaran berhasil dihapus.',
            'time'    => $formattedTime,
            'judul'   => 'Berhasil',
        ]);
    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error'        => 'Terjadi kesalahan saat menghapus data pengeluaran.',
            'time'         => $formattedTime,
            'judul'        => 'Gagal',
            'errorMessage' => $e->getMessage(),
        ]);
    }
}


        
    


}
