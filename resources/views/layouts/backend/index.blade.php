<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: MetronicProduct Version: 8.2.7
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords"
        content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="http://preview.keenthemes.comindex.html" />
    <link rel="shortcut icon"
        href="{{ $appSetting && $appSetting->favicon ? asset('storage/' . $appSetting->favicon) : asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        body {
            background-image: url('{{ asset('assets/media/auth/bg10.jpeg') }}');
        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ asset('assets/media/auth/bg10-dark.jpeg') }}');
        }
    </style>


    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    @stack('stylesheets')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
    data-kt-app-header-stacked="true" data-kt-app-header-primary-enabled="true" class="app-default">
    <!--begin::loader-->
    <div class="page-loader flex-column">
        {{-- Logo Light (background putih → pakai logo hitam) --}}
        @if ($appSetting && $appSetting->logo_black)
            <img alt="Logo" class="theme-light-show max-h-50px"
                src="{{ asset('storage/' . $appSetting->logo_black) }}" />
        @else
            <img alt="Logo" class="theme-light-show max-h-50px"
                src="{{ asset('assets/media/logos/keenthemes.svg') }}" />
        @endif

        {{-- Logo Dark (background hitam → pakai logo putih) --}}
        @if ($appSetting && $appSetting->logo_white)
            <img alt="Logo" class="theme-dark-show max-h-50px"
                src="{{ asset('storage/' . $appSetting->logo_white) }}" />
        @else
            <img alt="Logo" class="theme-dark-show max-h-50px"
                src="{{ asset('assets/media/logos/keenthemes-dark.svg') }}" />
        @endif

        <div class="d-flex align-items-center mt-5">
            <span class="spinner-grow text-primary" role="status"></span>
            <span class="text-muted fs-6 fw-semibold ms-5">Loading...</span>
        </div>
    </div>

    <!--end::Loader-->
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->

   
      
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">

        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header">
                <div class="app-header-primary " data-kt-sticky="true" data-kt-sticky-name="app-header-primary-sticky"
                    data-kt-sticky-offset="{default: 'false', lg: '300px'}">
                    <!--begin::Header primary container-->
                    <div class="app-container  container-xxl d-flex align-items-stretch justify-content-between "
                        id="kt_app_header_primary_container">

                        <!--begin::Logo and search-->
                        <div class="d-flex flex-grow-1 flex-lg-grow-0">
                            <!--begin::Logo wrapper-->
                            <div class="d-flex align-items-center me-7" id="kt_app_header_logo_wrapper">
                                <!--begin::Header toggle-->
                                <button
                                    class="d-lg-none btn btn-icon btn-flex btn-color-gray-600 btn-active-color-primary w-35px h-35px ms-n2 me-2"
                                    id="kt_app_header_menu_toggle">
                                    <i class="ki-outline ki-abstract-14 fs-2"></i>
                                </button>
                                <!--end::Header toggle-->
                                <!--begin::Logo-->
                                <a href="{{ route('dashboard') }}" class="d-flex align-items-center me-lg-20 me-5">

                                    {{-- Logo Mobile --}}
                                    @if ($appSetting && $appSetting->logo_mobile)
                                        <img alt="Logo Mobile" src="{{ asset('storage/' . $appSetting->logo_mobile) }}"
                                            class="h-20px d-sm-none d-inline" />
                                    @else
                                        <img alt="Logo Mobile"
                                            src="{{ asset('assets/media/logos/demo-35-small.svg') }}"
                                            class="h-20px d-sm-none d-inline" />
                                    @endif

                                    {{-- Logo Black (dipakai untuk tema light = background putih) --}}
                                    @if ($appSetting && $appSetting->logo_black)
                                        <img alt="Logo Black" src="{{ asset('storage/' . $appSetting->logo_black) }}"
                                            class="h-20px h-lg-25px theme-light-show d-none d-sm-inline" />
                                    @else
                                        <img alt="Logo Black" src="{{ asset('assets/media/logos/demo-35.svg') }}"
                                            class="h-20px h-lg-25px theme-light-show d-none d-sm-inline" />
                                    @endif

                                    {{-- Logo White (dipakai untuk tema dark = background hitam) --}}
                                    @if ($appSetting && $appSetting->logo_white)
                                        <img alt="Logo White" src="{{ asset('storage/' . $appSetting->logo_white) }}"
                                            class="h-20px h-lg-25px theme-dark-show d-none d-sm-inline" />
                                    @else
                                        <img alt="Logo White" src="{{ asset('assets/media/logos/demo-35-dark.png') }}"
                                            class="h-20px h-lg-25px theme-dark-show d-none d-sm-inline" />
                                    @endif

                                </a>

                                <!--end::Logo-->
                            </div>
                            <!--end::Logo wrapper-->
                            <!--begin::Menu wrapper-->
                            @include('layouts.backend.menu')
                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::Logo and search-->
                        <!--begin::Navbar-->
                        @include('layouts.backend.navbar')
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header primary container-->
                </div>
                <!--end::Header primary-->
                <!--begin::Header secondary-->
                {{-- @include('layouts.backend.secondary-header') --}}
                <!--end::Header secondary-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Wrapper container-->
                <div class="app-container container-xxl d-flex flex-row flex-column-fluid">
                    {{-- @php
                    $isFullPage = in_array(Route::currentRouteName(), ['barang-masuk.show']);
                @endphp
                
                <div class="app-container {{ $isFullPage ? 'container-fluid px-0' : 'container-xxl' }} d-flex flex-row flex-column-fluid">
                 --}}
                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Content-->
                            @yield('content')
                            <!--end::Content-->
                        </div>
                        <!--end::Content wrapper-->
                        <!--begin::Footer-->
                        @include('layouts.backend.footer')
                        <!--end::Footer-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper container-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ asset('assets/') }}";
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--end::Javascript-->
    @stack('scripts')
</body>
<!--end::Body-->

</html>
