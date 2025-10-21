@extends('layouts.backend.index')
@section('title', 'History Penjualan Barang')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
    <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                History Penjualan Barang
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a></li>
                <li class="breadcrumb-item text-gray-900">History Barang</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div class="card border-top-accent shadow-sm mb-5">
        <div class="card-header bg-light border-gray-400">
            <div class="card-title">
                <h3 class="fw-bold mb-0">Data Barang</h3>
            </div>

			
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nama Barang:</strong> {{ $barang->nama }}<br>
                    <strong>Kode:</strong> {{ $barang->kode_barang }}
                </div>
                <div class="col-md-4">
                    <strong>Kategori:</strong> {{ $barang->kategori->nama ?? '-' }}<br>
                    <strong>Brand:</strong> {{ $barang->brand->nama ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Stok Saat Ini:</strong> {{ $barang->stok }} {{ $barang->satuan->singkatan ?? '-' }}<br>
                    <strong>Size:</strong> {{ $barang->size ?? '-' }}
                </div>
            </div>
        </div>
    </div>

   <div class="card border-top-accent shadow-sm mb-5">
        <div class="card-header bg-light border-gray-400">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Data Laporan Penjualan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                       <button id="resetFilter" type="button" class="btn btn-secondary btn-sm">
					<i class="ki-outline ki-arrows-circle fs-5 me-1"></i>Reset
					</button>
                        <div class="position-relative">
                           <input id="filter_tanggal"
						name="filter_tanggal"
						type="text"
						class="form-control form-control-sm"
						placeholder="Pilih tanggal penjualan"
						autocomplete="off"
						style="min-width:230px" />
                        </div>
                    </div>
                </div>
            </div>


        <div class="card-body py-4">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100" id="tableHistory">
    <thead>
        <tr class="fw-bold text-muted text-uppercase">
            <th>Tanggal</th>
            <th>Kode Transaksi</th>
            <th>Kategori</th>
            <th>Qty</th>
            <th>Harga Jual</th>
            <th>Subtotal</th>
        </tr>
    </thead>
</table>

        </div>
    </div>
</div>
@endsection

@push('stylesheets')
<style>
    .card.border-top-accent { border-top: 3px solid #0d6efd; }
</style>
@endpush
@push('scripts')
<script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
$(document).ready(function () {
   let startDate = null;
let endDate = null;

flatpickr("#filter_tanggal", {
  mode: "range",
  dateFormat: "Y-m-d",
  
  onClose: function(selectedDates, dateStr, instance) {
    // dateStr sudah dalam format "Y-m-d" atau "Y-m-d to Y-m-d"
    if (!dateStr) {
      startDate = endDate = null;
      return;
    }

    const [start, end] = dateStr.split(" to ");
    startDate = start || null;
    endDate   = end || start || null; // kalau cuma pilih 1 tanggal, end = start

    table.ajax.reload();
  }
});

// Reset
$('#resetFilter').on('click', function() {
  $('#filter_tanggal').val('');
  startDate = endDate = null;
  table.ajax.reload();
});



    // ⚙️ Inisialisasi DataTables
    var table = $('#tableHistory').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: "{{ route('barang.history.data', $barang->id) }}",
            data: function (d) {
                d.start_date = startDate;
                d.end_date = endDate;
            }
        },
        columns: [
            { data: 'tanggal', name: 'tanggal' },
            { data: 'kode', name: 'kode' },
            { data: 'kategori_penjualan', name: 'kategori_penjualan' },
            { data: 'qty', name: 'qty', className: 'text-center' },
            { data: 'harga_jual', name: 'harga_jual', className: 'text-end' },
            { data: 'subtotal', name: 'subtotal', className: 'text-end' }
        ],
        language: {
            processing: "Memuat data...",
            zeroRecords: "Tidak ada data ditemukan",
            emptyTable: "Belum ada riwayat penjualan",
            search: "Cari:",
            lengthMenu: "_MENU_",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            paginate: { previous: "‹", next: "›" }
        }
    });
});
</script>
@endpush


