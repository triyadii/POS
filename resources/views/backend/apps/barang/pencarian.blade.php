@extends('layouts.backend.index')
@section('title', 'Pencarian Barang')
@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
    <!--begin::Toolbar wrapper-->
    <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Pencarian Barang
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Apps</li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-gray-900">Pencarian Barang</li>
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
    <div class="card border-top-accent shadow-sm mb-5">
        <div class="card-header bg-light py-4">
            <div class="card-title w-100">
                <div class="d-flex align-items-center position-relative my-1 w-100">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                    <input type="text" id="search" class="form-control ps-13"
                        placeholder="Cari nama atau kode barang..." autocomplete="off" />
                </div>
            </div>
        </div>

        
    </div>

    <div class="card border-top-accent shadow-sm mb-5">
       

         <div class="card-body py-4">

                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100 chimox" id="chimox">
                    <thead>
                        <tr class="fw-bold text-muted fs-7 text-uppercase gs-0">         
                            <th class="min-w-125px">Kode Item</th>
                   
                            <th class="min-w-125px">Nama Item</th>
                            <th class="min-w-70px">Kategori</th>
                            <th class="min-w-100px">Brand</th>
                            <th class="min-w-50px">Size</th>
                            <th class="min-w-100px">Stok</th>
                            <th class="text-end min-w-100px">Harga</th>
                            <th class="text-end min-w-100px">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>


            </div>
            <!--end::Card body-->
    </div>
</div>
<!--end::Content-->

@endsection

@push('stylesheets')
<meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
<style>
    .card.border-top-accent {
        border-top: 3px solid #0d6efd;
    }
</style>


@endpush



@push('scripts')
<script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
$(document).ready(function () {
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // 🧩 Pesan awal (instruksi)
    const infoMessage = `
        <div id="infoMessage" class="text-center py-10">
            <i class="ki-outline ki-magnifier fs-2x mb-3 d-block text-muted"></i>
            <span class="fw-semibold fs-5 text-gray-700">
                Cari item barang berdasarkan <span class="text-primary">kode item</span> atau 
                <span class="text-primary">nama barang</span>
            </span>
        </div>
    `;

    // Tambahkan pesan info di bawah card filter
    $('.border-top-accent.shadow-sm.mb-5').first().after(infoMessage);

    // 🚫 Sembunyikan card tabel saat awal
    const $cardTable = $('.border-top-accent.shadow-sm.mb-5').last();
    $cardTable.hide();

    // Inisialisasi DataTable
    var table = $('.chimox').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        paging: true,
        searching: false,
        ajax: {
            url: "{{ route('pencarianList.barang') }}",
            type: 'GET',
            data: function (d) {
                d.search = { value: $('#search').val() };
            },
            beforeSend: function (xhr, settings) {
                const query = $('#search').val();
                if (!query) {
                    xhr.abort(); // batalkan jika belum ada filter
                }
            }
        },
        language: {
            zeroRecords: "Tidak ada data ditemukan",
            emptyTable: "Tidak ada data tersedia",
        },
        columns: [
                        { data: 'kode', name: 'kode' },

            { data: 'nama', name: 'nama' },
            { data: 'kategori_id', name: 'kategori_id' , orderable: false, searchable: false},
            { data: 'brand_id', name: 'brand_id' , orderable: false, searchable: false},
            { data: 'size', name: 'size', orderable: false, searchable: false },
            { data: 'stok', name: 'stok' , orderable: false, searchable: false},
            { data: 'harga_jual', name: 'harga_jual' , orderable: false, searchable: false},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // 🔍 Saat user mengetik filter
    $('#search').on('keyup', debounce(function () {
        const val = $(this).val().trim();

        if (val.length > 0) {
            $('#infoMessage').hide();    // sembunyikan pesan instruksi
            $cardTable.show();           // tampilkan card tabel
            table.ajax.reload();         // reload data
        } else {
            $cardTable.hide();           // sembunyikan card tabel lagi
            $('#infoMessage').show();    // tampilkan pesan instruksi
            table.clear().draw();        // kosongkan isi tabel
        }
    }, 400));
});
</script>
@endpush
