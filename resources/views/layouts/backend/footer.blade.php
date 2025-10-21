<div id="kt_app_footer"
    class="app-footer align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3 py-lg-6">
    <!--begin::Copyright-->
    <div class="text-gray-900 order-2 order-md-1">
        <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
        <a class="text-gray-800 text-hover-primary">{!! $appSetting->footer ?? 'rizkychimo ' !!}</a>
    </div>
    <!--end::Copyright-->
    <!--begin::Menu-->
    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
        <li class="menu-item">
            @php
                $latestChangelog = app(
                    'App\Http\Controllers\Backend\Footer\BackendFooterController',
                )->getLatestChangelog();
            @endphp
            @if (isset($latestChangelog))
                <span class="menu-link px-2">{{ $latestChangelog->nama }}</span>
            @else
                <span class="menu-link px-2">No version available</span>
            @endif
        </li>

    </ul>
    <!--end::Menu-->
</div>
