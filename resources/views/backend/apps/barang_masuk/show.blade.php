@extends('layouts.backend.index')
@section('title', 'Barang Masuk Detail')
@section('content')

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Barang Masuk
                    Details</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Apps</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Barang Masuk</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-900">Barang Masuk Detail</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->

 
    
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        
        <div class="card border-top-accent shadow-sm mb-xl-10 mb-5">
            <div class="card-header d-flex justify-content-between align-items-center border-gray-400">
                <h3 class="card-title">Detail Barang Masuk</h3>
                <div class="card-toolbar">
                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ki-outline ki-arrow-left fs-2"></i> Kembali
                    </a>
                </div>
            </div>
        
            <div class="card-body">
                <div class="mb-5">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode Transaksi</th>
                            <td>{{ $data->kode_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <td>{{ $data->tanggal_masuk }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $data->supplier?->nama ?? 'Tidak ada supplier' }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $data->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
        
               
            </div>
        </div>


        





    </div>
    <!--end::Content-->

    <div class="position-relative" 
     style="left:50%; width:99vw; margin-left:-50vw; padding-left:8vw; padding-right:8vw;">
     {{-- <div class="position-relative px-10" style="left:50%;width:100vw;margin-left:-50vw;"> --}}

    <div class="card border-top-accent shadow-sm mb-10" id="itemdetailbarangmasuk">
        <div class="card-header d-flex justify-content-between align-items-center border-gray-400">
            <h3 class="card-title">Transaksi: {{ $data->kode_transaksi }}</h3>
            @if($data->status !== 'final')
                <div class="card-toolbar">
                    <a id="btnFinalize" class="btn btn-success btn-sm mt-3">
                        <i class="ki-outline ki-printer fs-2"></i> Finalisasi & Cetak
                    </a>
                </div>
            @endif

        </div>

        <div class="card-body">
            @if($data->status !== 'final')
            <form id="formAddDetail" class="d-flex gap-2 align-items-center mb-5" autocomplete="off">
                <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                       placeholder="Scan / ketik kode barang..." autofocus required>
                <input type="number" class="form-control" id="qty" name="qty" value="1" min="1" style="width:100px;">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ki-outline ki-plus fs-2"></i> Add
                </button>
            </form>
        @endif
        

            <table id="table-detail" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100ssss">
                <thead class="bg-light fw-bold">
                    <tr class="fw-bold text-muted fs-7 text-uppercase gs-0">                            
                        <th width="5%">No</th>
                        <th>Barang</th>
                        <th>Kategori</th>
                        <th>Brand & Tipe</th>
                        <th>Size</th>
                        <th class="text-end min-w-80px">Qty</th>

                        <th class="text-end min-w-80px">Harga Jual</th>
                        <th class="text-end min-w-80px">Harga Beli</th>
                        <th class="text-end min-w-80px">Subtotal</th>
                        @if($data->status !== 'final')
                            <th class="text-end min-w-10px">Aksi</th>
                        @endif
                    </tr>
                </thead>
            </table>
            <div class="d-flex justify-content-end mt-4">
                <div class="text-end">
                    <h5 class="fw-bold mb-0">Total Transaksi:</h5>
                    <div id="total-transaksi" class="fs-5 text-success fw-bolder">Rp 0</div>
                </div>
            </div>
            
        </div>
    </div>
</div>


    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">

            
        
        <style>
            /* Accent line merah di atas card */
            .card.border-top-accent {
                border-top: 3px solid #0d6efd; /* warna pink/merah Metronic */
                border-radius: 0.475rem;       /* tetap sesuai Metronic radius */
                box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);

                
            }
            
            /* Opsional: agar header lebih rapat dan bersih */
            .card-header {
                border-bottom: none;
                padding-top: 1rem;
                padding-bottom: 0.5rem;
            }

            .editable-price {
    cursor: pointer;
    border-bottom: 1px dashed #0d6efd;
}
.editable-price:hover {
    color: #0d6efd;
}

            
            
            </style>
    @endpush
    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script>
$(function() {
    const barangMasukId = "{{ $data->id }}";

    const table = $('#table-detail').DataTable({
    ajax: "{{ route('barang-masuk.detail.list', $data->id) }}",
    processing: true,
    serverSide: true,
    order: [],
    columns: [
    { data: 'DT_RowIndex', orderable: false, searchable: false },
    { data: 'barang_info', name: 'barang_info' },
    { data: 'kategori', name: 'kategori' },
    { data: 'brand_tipe', name: 'brand_tipe' },
    { data: 'size', name: 'size' },
    { data: 'qty', name: 'qty' },
    { data: 'harga_jual', name: 'harga_jual' },
    { data: 'harga_beli', name: 'harga_beli' },
   
    { data: 'subtotal', name: 'subtotal' },
    @if($data->status !== 'final')
            { data: 'action', orderable: false, searchable: false },
        @endif
]

});


// === CEGAH ENTER KIRIM FORM ===
$(document).on('keypress', 'form input', function (e) {
    if (e.which === 13) e.preventDefault();
});


// 🔹 Inline Edit Harga
$('#table-detail').on('click', '.editable-price', function () {
    const span = $(this);
    const oldValue = span.text().replace(/[^\d]/g, '');
    const id = span.data('id');
    const field = span.data('field');

    // Ganti teks jadi input
    const input = $('<input type="number" min="0" class="form-control form-control-sm text-end" style="width:100px;">')
        .val(oldValue)
        .on('blur keypress', function (e) {
            if (e.type === 'blur' || e.which === 13) {
                const newValue = parseInt($(this).val());
                if (isNaN(newValue)) {
                    span.text('Rp ' + Number(oldValue).toLocaleString('id-ID'));
                    return;
                }

                $.ajax({
                    url: "{{ route('barang-masuk.detail.update-price') }}",
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                        field: field,
                        value: newValue
                    },
                    success: res => {
                        if (res.success) {
                            span.text('Rp ' + newValue.toLocaleString('id-ID'));
                            toastr.success('Harga berhasil diperbarui');
                            $('#table-detail').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error('Gagal memperbarui harga');
                        }
                    },
                    error: () => {
                        toastr.error('Terjadi kesalahan saat update harga');
                    }
                });
            }
        });

    span.html(input);
    input.focus().select();
});



table.on('xhr.dt', function (e, settings, json) {
    if (json?.data?.length) {
        let total = json.data.reduce((sum, item) => {
            const subtotal = item.subtotal ? 
                parseInt(item.subtotal.replace(/\D/g, '')) : 0;
            return sum + subtotal;
        }, 0);
        $('#total-transaksi').text('Rp ' + total.toLocaleString('id-ID'));
    } else {
        $('#total-transaksi').text('Rp 0');
    }
});

$('#formAddDetail').on('submit', function(e) {
    e.preventDefault();

    if (!$('#kode_barang').val().trim()) {
        toastr.warning('Kode barang belum diisi');
        $('#kode_barang').focus();
        return;
    }

    if ($('#qty').val() <= 0) {
        toastr.warning('Qty harus lebih dari 0');
        return;
    }
    $.post(`/barang-masuk/${barangMasukId}/detail/add`, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        kode_barang: $('#kode_barang').val(),
        qty: $('#qty').val()
    }).done(res => {
        if (res.success) {
            toastr.success('Barang ditambahkan');
            $('#kode_barang').val('').focus();
            $('#qty').val(1);
            table.ajax.reload();
        } else {
            toastr.error(res.message);
        }
    });
});

// 🔹 Event hapus detail
$('#table-detail').on('click', '.btn-delete-detail', function () {
    const detailId = $(this).data('id');

    Swal.fire({
        title: 'Hapus Data?',
        text: 'Apakah Anda yakin ingin menghapus item ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/barang-masuk/detail/${detailId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        toastr.success('Item berhasil dihapus');
                        table.ajax.reload();
                    } else {
                        toastr.error('Gagal menghapus data');
                    }
                },
                error: function () {
                    toastr.error('Terjadi kesalahan saat menghapus data');
                }
            });
        }
    });
});

$('#btnFinalize').on('click', function() {
    Swal.fire({
        title: 'Finalisasi Transaksi?',
        text: 'Setelah finalisasi, transaksi tidak bisa diubah.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, finalisasi',
    }).then(result => {
        if (result.isConfirmed) {
            $.post(`/barang-masuk/${barangMasukId}/finalize`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, res => {
                toastr.success('Transaksi berhasil difinalisasi');
                window.location.href = "{{ route('barang-masuk.index') }}";
            });
        }
    });
});



});
</script>
    @endpush
@endsection
