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
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Total Penjualan Hari ini</span>
                        <span class="fw-bold fs-2x text-success">
                            <span class="fs-7 text-gray-600 mb-3">Rp. </span>
                            {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}
                        </span>
                        <span class="fs-7 text-gray-600 mb-3">{{ $tanggalHariIni }}</span>
                    </div>
                </div>
            </div>



            <!-- Card 2 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Total Pengeluaran Hari ini</span>
                        <span class="fw-bold fs-2x text-danger">
                            <span class="fs-7 text-gray-600 mb-3">Rp. </span>
                            {{ number_format($totalPengeluaranHariIni, 0, ',', '.') }}
                        </span>
                        <span class="fs-7 text-gray-600 mb-3">{{ $tanggalHariIni }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Produk Terjual</span>
                        <span class="fw-bold fs-2x text-dark">
                            {{ number_format($produkTerjualHariIni, 0, ',', '.') }}
                        </span>
                        <span class="fs-7 text-gray-600 mb-3">{{ $tanggalHariIni }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-stretch mb-xl-8">
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted fw-bold fs-7">Laba Bersih</span>
                        <span class="fw-bold fs-2x text-dark">
                            <span class="fs-7 text-gray-600 mb-3">Rp. </span>
                            {{ number_format($labaBersihHariIni, 0, ',', '.') }}
                        </span>
                        <span class="fs-7 text-gray-600 mb-3">{{ $tanggalHariIni }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 g-xl-8">
            <div class="col-xl-8">
                {{-- WIDGET BARU: CHART TREN PENJUALAN --}}
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">Tren Penjualan</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">7 Hari Terakhir</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="sales_trend_chart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                {{-- WIDGET BARU: NOTIFIKASI STOK KRITIS --}}
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bold text-gray-900">Notifikasi Stok Kritis</h3>
                    </div>
                    <div class="card-body pt-0">
                        @forelse ($stokKritis as $item)
                            <div class="d-flex align-items-center {{ $loop->last ? 'mb-0' : 'mb-7' }}">
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-danger">
                                        <i class="ki-outline ki-abstract-24 fs-2x text-danger"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#"
                                        class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $item->nama }}</a>
                                    <span
                                        class="text-muted d-block fw-semibold">{{ optional($item->brand)->nama ?? 'No Brand' }}</span>
                                </div>
                                <div class="fw-bold text-danger py-1">{{ $item->stok }} Pcs</div>
                            </div>
                        @empty
                            <div class="d-flex flex-column flex-center h-200px">
                                <i class="ki-outline ki-like fs-4x text-success"></i>
                                <span class="text-muted fs-6 mt-5">Semua stok dalam kondisi aman.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
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

            document.addEventListener("DOMContentLoaded", function() {
                const chartElement = document.getElementById('sales_trend_chart');
                if (!chartElement) {
                    return;
                }

                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');
                const trenPenjualanData = @json($trenPenjualan);

                const options = {
                    series: [{
                        name: 'Pendapatan',
                        data: trenPenjualanData.map(item => item.total)
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'area',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 0.3
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTUtil.getCssVariableValue('--bs-success')]
                    },
                    xaxis: {
                        categories: trenPenjualanData.map(item => item.tanggal),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '12px'
                            }
                        },
                        crosshairs: {
                            position: 'front',
                            stroke: {
                                color: KTUtil.getCssVariableValue('--bs-success'),
                                width: 1,
                                dashArray: 3
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: (val) => formatRupiah(val),
                            style: {
                                colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '12px'
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: (val) => formatRupiah(val)
                        }
                    },
                    colors: [KTUtil.getCssVariableValue('--bs-success')],
                    grid: {
                        borderColor: KTUtil.getCssVariableValue('--bs-gray-200'),
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    markers: {
                        strokeColor: KTUtil.getCssVariableValue('--bs-success'),
                        strokeWidth: 3
                    }
                };

                const chart = new ApexCharts(chartElement, options);
                chart.render();
            });
        </script>
    @endpush
@endsection
