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
                    <input type="text" id="searchBarang" class="form-control ps-13"
                        placeholder="Cari nama atau kode barang..." autocomplete="off" />
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="resultContainer" class="table-responsive d-none">
                <table class="table align-middle table-row-dashed gy-3">
                    <thead>
                        <tr class="fw-bold text-muted text-uppercase">
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Brand</th>
                            <th>Size</th>
                            <th class="text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody id="resultTable"></tbody>
                </table>
            </div>
            <div id="emptyMessage" class="text-center py-10 text-gray-500">
                Ketik nama atau kode barang untuk mencari...
            </div>
        </div>
    </div>
</div>
<!--end::Content-->

@endsection

@push('stylesheets')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .card.border-top-accent {
        border-top: 3px solid #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
    "use strict";

    $(document).ready(function() {
        let typingTimer;
        const delay = 400;
        const $input = $("#searchBarang");
        const $result = $("#resultContainer");
        const $table = $("#resultTable");
        const $empty = $("#emptyMessage");

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }

        function searchBarang(query) {
            if (!query) {
                $result.addClass("d-none");
                $empty.removeClass("d-none").text("Ketik nama atau kode barang untuk mencari...");
                return;
            }

            $.ajax({
                url: "{{ route('pencarianList.barang') }}",
                type: "GET",
                data: {
                    q: query
                },
                beforeSend: function() {
                    $empty.removeClass("d-none").text("Mencari...");
                    $result.addClass("d-none");
                },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        let rows = "";
                        response.data.forEach(item => {
                            rows += `
                            <tr>
                                <td>${item.kode ?? '-'}</td>
                                <td>${item.nama ?? '-'}</td>
                                <td>${item.kategori ?? '-'}</td>
                                <td>${item.brand ?? '-'}</td>
                                <td>${item.size ?? '-'}</td>
                                <td class="text-center">${item.stok ?? 0}</td>
                            </tr>`;
                        });
                        $table.html(rows);
                        $result.removeClass("d-none");
                        $empty.addClass("d-none");
                    } else {
                        $result.addClass("d-none");
                        $empty.removeClass("d-none").text("Tidak ada barang ditemukan.");
                    }
                },
                error: function() {
                    $result.addClass("d-none");
                    $empty.removeClass("d-none").text("Terjadi kesalahan saat mengambil data.");
                }
            });
        }

        $input.on("keyup", function() {
            clearTimeout(typingTimer);
            const query = $(this).val().trim();
            typingTimer = setTimeout(() => searchBarang(query), delay);
        });
    });
</script>
@endpush