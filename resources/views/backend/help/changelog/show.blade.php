@extends('layouts.backend.index')
@section('title', 'Changelog Detail')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8 mb-5">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ $data->nama }}</h1>
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
                    <li class="breadcrumb-item text-muted">Help</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Changelog</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-900">{{ $data->nama }}</li>
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
    <div id="kt_app_content" class="app-content">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Changelog Details</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-3 fw-semibold text-muted">Nama dan Versi Changelog</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <span class="fw-bold fs-6 text-gray-800">{{ $data->nama }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-3 fw-semibold text-muted">Deskripsi Changelog</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9 fv-row">
                        <span class="fw-semibold text-gray-800 fs-6">{{ $data->deskripsi }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
        </div>
        <!--begin::Row-->
        <div class="row gx-5 gx-xl-10">
            <!--begin::Col-->
            <div class="col-xxl-4 mb-5 mb-xl-10">
                <!--begin::Chart widget 27-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header pt-5 mb-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">New</span>
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Fitur Baru Aplikasi</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-1">
                        @if (empty($newLogs))
                            <div class="d-flex flex-column mb-1">
                                <li class="d-flex align-items-center mb-n2">
                                    <span class="ki-outline ki-pin me-2 text-success"></span>
                                    <span class="fw-semibold text-gray-800 fs-6">Tidak ada fitur baru</span>
                                </li>
                                <li class="d-flex align-items-center py-2">
                                    <span class="ki-outline ki-paper-clip me-2 text-info"></span>
                                    <span class="fw-semibold text-muted">Pada pembaharuan kali ini, tidak ada fitur
                                        baru</span>
                                </li>

                            </div>
                        @else
                            @foreach ($newLogs as $log)
                                <div class="d-flex flex-column mb-1">
                                    <li class="d-flex align-items-center mb-n2">
                                        <span class="ki-outline ki-pin me-2 text-success"></span>
                                        <span class="fw-semibold text-gray-800 fs-6">{{ ucfirst($log['nama']) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center py-2">
                                        <span class="ki-outline ki-paper-clip me-2 text-info"></span>
                                        <span class="fw-semibold text-muted">{{ ucfirst($log['deskripsi']) }}</span>
                                    </li>
                                    <div class="separator my-2"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Chart widget 27-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-4 mb-5 mb-xl-10">
                <!--begin::Chart widget 28-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header pt-5 mb-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Update</span>
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Pembaharuan Aplikasi</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-1">
                        @if (empty($updateLogs))
                            <div class="d-flex flex-column mb-1">
                                <li class="d-flex align-items-center mb-n2">
                                    <span class="ki-outline ki-pin me-2 text-success"></span>
                                    <span class="fw-semibold text-gray-800 fs-6">Tidak ada update</span>
                                </li>
                                <li class="d-flex align-items-center py-2">
                                    <span class="ki-outline ki-paper-clip me-2 text-info"></span>
                                    <span class="fw-semibold text-muted">Pada pembaharuan kali ini, tidak ada yang di
                                        update</span>
                                </li>

                            </div>
                        @else
                            @foreach ($updateLogs as $log)
                                <div class="d-flex flex-column mb-1">
                                    <li class="d-flex align-items-center mb-n2">
                                        <span class="ki-outline ki-pin me-2 text-success"></span>
                                        <span class="fw-semibold text-gray-800 fs-6">{{ ucfirst($log['nama']) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center py-2">
                                        <span class="ki-outline ki-paper-clip me-2 text-info"></span>
                                        <span class="fw-semibold text-muted">{{ ucfirst($log['deskripsi']) }}</span>
                                    </li>
                                    <div class="separator my-2"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Chart widget 28-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-4 mb-5 mb-xl-10">
                <!--begin::List widget 9-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header pt-5 mb-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Fix</span>
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Perbaikan Aplikasi</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-1">
                        @if (empty($fixLogs))
                            <div class="d-flex flex-column mb-1">
                                <li class="d-flex align-items-center mb-n2">
                                    <span class="ki-outline ki-pin me-2 text-success"></span>
                                    <span class="fw-semibold text-gray-800 fs-6">Tidak ada perbaikan</span>
                                </li>
                                <li class="d-flex align-items-center py-2">
                                    <span class="ki-outline ki-paper-clip me-2 text-info"></span>
                                    <span class="fw-semibold text-muted">Pada pembaharuan kali ini, tidak ada yang di
                                        perbaiki</span>
                                </li>

                            </div>
                        @else
                            @foreach ($fixLogs as $log)
                                <div class="d-flex flex-column mb-1">
                                    <li class="d-flex align-items-center mb-n2">
                                        <span class="ki-outline ki-pin me-2 text-success"></span>
                                        <span class="fw-semibold text-gray-800 fs-6">{{ ucfirst($log['nama']) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center py-2">
                                        <span class="ki-outline ki-paper-clip me-2 text-info"></span>
                                        <span class="fw-semibold text-muted">{{ ucfirst($log['deskripsi']) }}</span>
                                    </li>
                                    <div class="separator my-2"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List widget 9-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Content-->
    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @push('scripts')
    @endpush
@endsection
