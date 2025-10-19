@extends('layouts.backend.index')
@section('title', 'Setting App')
@section('content')


    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Setting
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Setting</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">App</li>
                    <!--end::Item-->

                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->

    <div id="kt_app_content" class="app-content flex-column-fluid">

        <div class="row g-5 g-xl-10">


            <!--begin::Timeline Widget 4-->
            <div class="card h-md-100">
                <!--begin::Card header-->
                <div class="card-header position-relative py-0 border-bottom-1">
                    <!--begin::Card title-->
                    <h3 class="card-title text-gray-800 fw-bold">Pengaturan Aplikasi</h3>
                    <!--end::Card title-->
                    <!--begin::Tabs-->
                    <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4" role="tablist">
                        <!--begin::Nav item-->
                        <li class="nav-item p-0 ms-0" role="presentation">
                            <a class="nav-link btn btn-color-gray-500 flex-center px-3 active"
                                data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#global" aria-selected="true"
                                role="tab">
                                <!--begin::Title-->
                                <span class="nav-text fw-semibold fs-4 mb-3">Global</span>
                                <!--end::Title-->
                                <!--begin::Bullet-->
                                <span
                                    class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                                <!--end::Bullet-->
                            </a>
                        </li>
                        <!--end::Nav item-->


                    </ul>
                    <!--end::Tabs-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pb-0">
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane blockui active show" id="global" role="tabpanel" aria-labelledby="day-tab"
                            data-kt-timeline-widget-4-blockui="true" style="">
                            <form action="{{ route('setting_app.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="mb-2">Logo Black Saat Ini</label>
                                        <div class="mb-2" style="min-height: 60px;">
                                            @if ($setting->logo_black)
                                                <img src="{{ asset('storage/' . $setting->logo_black) }}" height="50">
                                            @endif
                                        </div>
                                        <input type="file" name="logo_black" class="form-control mt-2">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="mb-2">Logo White Saat Ini</label>
                                        <div class="mb-2" style="min-height: 60px;">
                                            @if ($setting->logo_white)
                                                <img src="{{ asset('storage/' . $setting->logo_white) }}" height="50">
                                            @endif
                                        </div>
                                        <input type="file" name="logo_white" class="form-control mt-2">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="mb-2">Logo Mobile Saat Ini</label>
                                        <div class="mb-2" style="min-height: 60px;">
                                            @if ($setting->logo_mobile)
                                                <img src="{{ asset('storage/' . $setting->logo_mobile) }}" height="50">
                                            @endif
                                        </div>
                                        <input type="file" name="logo_mobile" class="form-control mt-2">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="mb-2">Favicon Saat Ini</label>
                                        <div class="mb-2" style="min-height: 60px;">
                                            @if ($setting->favicon)
                                                <img src="{{ asset('storage/' . $setting->favicon) }}" height="50">
                                            @endif
                                        </div>
                                        <input type="file" name="favicon" class="form-control mt-2">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label>Footer</label>
                                    <textarea name="footer" class="form-control">{{ old('footer', $setting->footer) }}</textarea>
                                </div>

                                <button class="btn btn-sm btn-primary mb-xl-10 mb-5">Simpan</button>
                            </form>
                        </div>
                        <!--end::Tab pane-->


                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Card body-->

            </div>
            <!--end::Col-->
        </div>



    </div>






    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @endpush
@endsection
