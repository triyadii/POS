@extends('layouts.backend.index')
@section('title', 'Role Detail')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8 mb-5">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Role
                    Detail</h1>
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
                    <li class="breadcrumb-item text-muted">Resources</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Role Management</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-900">Role {{ $role->name }}</li>
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
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content">
            <!--begin::Pricing card-->
            <div class="card" id="kt_pricing">
                <!--begin::Card body-->
                <div class="card-body p-lg-17">
                    <!--begin::Plans-->
                    <div class="d-flex flex-column">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <h1 class="fs-2 fw-bold mb-5">Role {{ $role->name }}</h1>
                        </div>
                        <!--end::Heading-->
                        <div class="row g-9 mb-8">
                            @foreach ($permissions as $category => $categoryItems)
                                <div class="col-md-3 fv-row">
                                    <label class="fs-6 fw-semibold mb-2">{{ $category }}</label>
                                    <!--begin::Wrapper-->
                                    <div>
                                        @foreach ($categoryItems as $item)
                                            <!--begin::Checkbox-->
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid mb-2 me-5 me-lg-2">
                                                <i class="ki-outline ki-check-square text-success me-2"></i><span
                                                    class="form-check-label">{{ $item->name }}</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        @endforeach
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <!--end::Plans-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Pricing card-->
        </div>
        <!--end::Content-->
        @push('stylesheets')
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endpush
        @push('scripts')
        @endpush
    @endsection
