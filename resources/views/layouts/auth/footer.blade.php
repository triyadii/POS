<div class="d-flex flex-stack">
    <!--begin::Languages-->
    <div class="me-10">
        <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
        <a class="text-gray-800 text-hover-primary">{!! $appSetting->footer ?? 'rizkychimo ' !!}</a>
    </div>
    <!--end::Languages-->
    <!--begin::Links-->
    <div class="d-flex fw-semibold text-muted fs-base gap-5">

        @php
            $latestChangelog = app('App\Http\Controllers\Backend\Footer\BackendFooterController')->getLatestChangelog();
        @endphp
        @if (isset($latestChangelog))
            <span class="px-2">{{ $latestChangelog->nama }}</span>
        @else
            <span class="px-2">No version available</span>
        @endif

    </div>
    <!--end::Links-->
</div>
