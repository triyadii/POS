@extends('layouts.backend.index')

@section('title', 'Detail Pengeluaran')

@section('content')




    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Pengeluaran
                    List</h1>
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
                    <li class="breadcrumb-item text-gray-900">Pengeluaran List</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center pt-4 pb-7 pt-lg-1 pb-lg-2">
                <!--begin::Wrapper-->
                <div class="me-3">
                    
                    <!--end::Menu-->
                </div>
                <!--end::Wrapper-->
              
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->


    <div id="kt_app_content" class="app-content flex-column-fluid">

<div class=" card border-top-accent shadow-sm mb-xl-10 mb-5">
    <div class="card-header d-flex justify-content-between align-items-center border-gray-400">
        <h3 class="card-title fw-bold text-dark">Detail Pengeluaran</h3>
        <div class="card-toolbar">
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-light-primary btn-sm">
                <i class="ki-outline ki-arrow-left fs-4 me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body py-4">
        <input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />

        <!-- ===================== -->
        <!-- 💰 INFORMASI UTAMA -->
        <!-- ===================== -->
        <div class="row mb-6">
            <div class="col-md-3">
                <label class="fw-semibold text-gray-700 d-block mb-1">Kode Transaksi</label>
                <input type="text" class="form-control form-control-solid" value="{{ $data->kode_transaksi }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="fw-semibold text-gray-700 d-block mb-1">Tanggal</label>
                <input type="text" class="form-control form-control-solid" 
                    value="{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}" readonly>
            </div>
            
            <div class="col-md-3">
                <label class="fw-semibold text-gray-700 d-block mb-1">Catatan</label>
                <input type="text" class="form-control form-control-solid" value="{{ $data->catatan ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="fw-semibold text-gray-700 d-block mb-1 text-end">Total Pengeluaran</label>
                <input type="text" class="form-control form-control-solid text-end fw-bold text-success"
                    value="Rp {{ number_format($data->total ?? 0, 0, ',', '.') }}" readonly>
            </div>
        </div>

        <hr class="my-5">

        <!-- ===================== -->
        <!-- 📋 DETAIL ITEM -->
        <!-- ===================== -->
        <h5 class="fw-bold text-gray-800 mb-4">Daftar Item Pengeluaran</h5>

        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100">
                <thead class="bg-light">
                    <tr class="fw-bold text-muted fs-7 text-uppercase gs-0">     
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Nama Item</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-end">Jumlah</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data->details as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategori->nama ?? '-' }}</td>
                            
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada item pengeluaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
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
    
    
    </style>
@endsection
