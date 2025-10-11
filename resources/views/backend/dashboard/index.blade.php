@extends('layouts.backend.index')
@section('title', 'Dashboard')
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">



        <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 mb-xl-10 mb-5">
            <!--begin::Toolbar wrapper-->
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Dashboards</h1>
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
                        <li class="breadcrumb-item text-gray-900">Dashboards</li>
                        <!--end::Item-->

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Toolbar wrapper-->
        </div>

        <div class="row g-5 g-xl-8">
            <!-- Card 1 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Total Penjualan Hari ini</span>
                        <span class="fw-bold fs-2x text-success"><span class="fs-7 text-gray-600 mb-3">Rp. </span>358.750.000 </span>
                        <span class="fs-7 text-gray-600 mb-3">Tanggal 01 September 2025</span>
                      
                    </div>
                </div>
            </div>



            <!-- Card 2 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Total Pengeluaran Hari ini</span>
                        <span class="fw-bold fs-2x text-danger"><span class="fs-7 text-gray-600 mb-3">Rp. </span>127.750.000 </span>
                        <span class="fs-7 text-gray-600 mb-3">Tanggal 01 September 2025</span>
                      
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Produk Terjual</span>
                        <span class="fw-bold fs-2x text-dark">3.741</span>
                        <span class="fs-7 text-gray-600 mb-3">Tanggal 01 September 2025</span>
                        
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Bersih</span>
                        <span class="fw-bold fs-2x text-dark"><span class="fs-7 text-gray-600 mb-3">Rp. </span>231.000.000 </span>
                        <span class="fs-7 text-gray-600 mb-3">Tanggal 01 September 2025</span>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 g-xl-8">
            <div class="col-xl-4">
                <!--begin::List Widget 4-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">Trends</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Latest tech trends</span>
                        </h3>
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-category fs-6"></i>
                            </button>
                            <!--begin::Menu 3-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Create Invoice</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link flex-stack px-3">Create Payment
                                        <span class="ms-2" data-bs-toggle="tooltip"
                                            aria-label="Specify a target name for future usage and reference"
                                            data-bs-original-title="Specify a target name for future usage and reference"
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-information fs-6"></i>
                                        </span></a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Generate Bill</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-title">Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Plans</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Billing</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Statements</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3">
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input w-30px h-20px" type="checkbox"
                                                        value="1" checked="checked" name="notifications">
                                                    <!--end::Input-->
                                                    <!--end::Label-->
                                                    <span class="form-check-label text-muted fs-6">Recuring</span>
                                                    <!--end::Label-->
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-1">
                                    <a href="#" class="menu-link px-3">Settings</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                            <!--end::Menu-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-5">
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <img src="assets/media/svg/brand-logos/plurk.svg" class="h-50 align-self-center"
                                        alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Top
                                        Authors</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Mark, Rowling, Esther</span>
                                </div>
                                <span class="badge badge-light fw-bold my-2">+82$</span>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <img src="assets/media/svg/brand-logos/telegram.svg" class="h-50 align-self-center"
                                        alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Popular
                                        Authors</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Randy, Steve, Mike</span>
                                </div>
                                <span class="badge badge-light fw-bold my-2">+280$</span>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <img src="assets/media/svg/brand-logos/vimeo.svg" class="h-50 align-self-center"
                                        alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">New
                                        Users</a>
                                    <span class="text-muted fw-semibold d-block fs-7">John, Pat, Jimmy</span>
                                </div>
                                <span class="badge badge-light fw-bold my-2">+4500$</span>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <img src="assets/media/svg/brand-logos/bebo.svg" class="h-50 align-self-center"
                                        alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Active
                                        Customers</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Mark, Rowling, Esther</span>
                                </div>
                                <span class="badge badge-light fw-bold my-2">+686$</span>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <img src="assets/media/svg/brand-logos/kickstarter.svg" class="h-50 align-self-center"
                                        alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Bestseller
                                        Theme</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Disco, Retro, Sports</span>
                                </div>
                                <span class="badge badge-light fw-bold my-2">+726$</span>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <img src="assets/media/svg/brand-logos/fox-hub.svg" class="h-50 align-self-center"
                                        alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Fox Broker
                                        App</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Finance, Corporate, Apps</span>
                                </div>
                                <span class="badge badge-light fw-bold my-2">+145$</span>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 4-->
            </div>

            <div class="col-xl-4">
                <!--begin::List Widget 6-->
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bold text-gray-900">Notifications</h3>
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-category fs-6"></i>
                            </button>
                            <!--begin::Menu 3-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Create Invoice</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link flex-stack px-3">Create Payment
                                        <span class="ms-2" data-bs-toggle="tooltip"
                                            aria-label="Specify a target name for future usage and reference"
                                            data-bs-original-title="Specify a target name for future usage and reference"
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-information fs-6"></i>
                                        </span></a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Generate Bill</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                    data-kt-menu-placement="right-end">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-title">Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Plans</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Billing</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Statements</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3">
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input w-30px h-20px" type="checkbox"
                                                        value="1" checked="checked" name="notifications">
                                                    <!--end::Input-->
                                                    <!--end::Label-->
                                                    <span class="form-check-label text-muted fs-6">Recuring</span>
                                                    <!--end::Label-->
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-1">
                                    <a href="#" class="menu-link px-3">Settings</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                            <!--end::Menu-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center bg-light-warning rounded p-5 mb-7">
                            <i class="ki-outline ki-abstract-26 text-warning fs-1 me-5"></i>
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2">
                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Group lunch
                                    celebration</a>
                                <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <span class="fw-bold text-warning py-1">+28%</span>
                            <!--end::Lable-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                            <i class="ki-outline ki-abstract-26 text-success fs-1 me-5"></i>
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2">
                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation
                                    optimization</a>
                                <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <span class="fw-bold text-success py-1">+50%</span>
                            <!--end::Lable-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center bg-light-danger rounded p-5 mb-7">
                            <i class="ki-outline ki-abstract-26 text-danger fs-1 me-5"></i>
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2">
                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Rebrand
                                    strategy
                                    planning</a>
                                <span class="text-muted fw-semibold d-block">Due in 5 Days</span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <span class="fw-bold text-danger py-1">-27%</span>
                            <!--end::Lable-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center bg-light-info rounded p-5">
                            <i class="ki-outline ki-abstract-26 text-info fs-1 me-5"></i>
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2">
                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Product goals
                                    strategy</a>
                                <span class="text-muted fw-semibold d-block">Due in 7 Days</span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <span class="fw-bold text-info py-1">+8%</span>
                            <!--end::Lable-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 6-->
            </div>

            <div class="col-xl-4">
                <!--begin::List Widget 5-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bold mb-2 text-gray-900">Activities</span>
                            <span class="text-muted fw-semibold fs-7" id="monthly-activity-count">Loading...</span>
                        </h3>
                        <div class="card-toolbar">
                            <a href="{{ route('log-activity.index') }}" class="btn btn-sm btn-light">View All</a>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body px-9 hover-scroll-overlay-y pe-7 me-3 mb-2 h-400px">
                        <div class="timeline-label" id="log-activities">
                            <!-- Data log aktivitas akan dimuat di sini -->
                        </div>
                    </div>

                    <!--end: Card Body-->
                </div>
                <!--end: List Widget 5-->
            </div>
        </div>


    </div>
    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

        <script>
            var logActivityRoute = @json(route('log-activity.show', ':id'));

            function loadLogActivities() {
                $.ajax({
                    url: "{{ route('log-activities.get') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        let timelineHtml = '';
                        response.activities.forEach(activity => {
                            let createdAt = new Date(activity.created_at);
                            let now = new Date();
                            let formattedTime;

                            // Hitung selisih waktu dalam milidetik
                            let timeDiff = now - createdAt;
                            let days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                            let weeks = Math.floor(days / 7);
                            let months = Math.floor(days / 30);
                            let years = Math.floor(days / 365);

                            if (days < 1) {
                                formattedTime = createdAt.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hourCycle: 'h23'
                                });
                            } else if (days < 7) {
                                formattedTime = `${days} days ago`;
                            } else if (weeks < 4) {
                                formattedTime = `${weeks} week${weeks > 1 ? 's' : ''} ago`;
                            } else if (months < 12) {
                                formattedTime = `${months} month${months > 1 ? 's' : ''} ago`;
                            } else {
                                formattedTime = `${years} year${years > 1 ? 's' : ''} ago`;
                            }

                            // Tentukan warna berdasarkan log_name
                            let logClass = "text-info"; // Default warna
                            if (activity.log_name === "login") {
                                logClass = "text-success";
                            } else if (activity.log_name === "logout") {
                                logClass = "text-danger";
                            }

                            // Tambahkan nama pengguna (causer) jika ada
                            let userName = activity.causer ? activity.causer.name : "Unknown User";

                            timelineHtml += `
    <div class="timeline-item">
        <div class="timeline-label fw-bold text-gray-800 fs-8">${formattedTime}</div>
        <div class="timeline-badge">
            <i class="fa fa-genderless ${logClass} fs-1"></i>
        </div>
        <div class=" timeline-content text-muted ps-6">
            <a href="${logActivityRoute.replace(':id', activity.id)}" class="text-black">
                ${userName} ${activity.description}
            </a>
        </div>
    </div>
`;

                        });

                        // Masukkan hasil ke dalam div dengan ID log-activities
                        $("#log-activities").html(timelineHtml);

                        // Tampilkan jumlah aktivitas bulan ini dengan titik sebagai pemisah ribuan
                        $("#monthly-activity-count").text(response.monthly_count.toLocaleString('id-ID') +
                            " activities this month");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading log activities:", error);
                    }
                });
            }

            // Panggil saat halaman pertama kali dimuat
            loadLogActivities();

            // Perbarui setiap 5 menit (300000 ms)
            setInterval(loadLogActivities, 300000);
        </script>
    @endpush
@endsection
