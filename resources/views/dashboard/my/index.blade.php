@extends('dashboard.layouts.main')

@section('content')
    <div class="alert alert-secondary mb-3">
        Selamat Datang kembali, {{ auth()->user()->name }}.
    </div>
        <div class="row">
            <!-- Work Permit Letters Statistics -->
            <div class="col-12 col-lg-5 col-xl-5 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Statisik SIK</h5>
                            <small class="text-muted">Klik bagian chart untuk melihat detail surat</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">{{ number_format($workPermitLetters->count(), 0, ',', '.') }}</h2>
                                <span>SIK Bulan Ini</span>
                            </div>
                            <div id="workPermitLettersStatisticsChart"></div>
                        </div>
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bx-checkbox-minus"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Aktif</h6>
                                        <small class="text-muted">SIK yang sedang aktif (berjalan)</small>
                                    </div>
                                    <div class="user-progress">
                                        <small
                                            class="fw-semibold">{{ number_format($activeWorkPermitLetters->count(), 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="bx bx-check-shield"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Selesai</h6>
                                        <small class="text-muted">SIK yang sudah selesai dan dikonfirmasi</small>
                                    </div>
                                    <div class="user-progress">
                                        <small
                                            class="fw-semibold">{{ number_format($finishedWorkPermitLetters->count(), 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x-circle"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Expired</h6>
                                        <small class="text-muted">SIK yang sudah expired</small>
                                    </div>
                                    <div class="user-progress">
                                        <small
                                            class="fw-semibold">{{ number_format($expiredWorkPermitLetters->count(), 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-info"><i class="bx bx-error"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Pending</h6>
                                        <small class="text-muted">SIK Pending, perlu direview</small>
                                    </div>
                                    <div class="user-progress">
                                        <small
                                            class="fw-semibold">{{ number_format($pendingWorkPermitLetters->count(), 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-warning"><i
                                            class="bx bx-info-circle"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Expire Hari Ini</h6>
                                        <small class="text-muted">SIK yang akan expire hari ini</small>
                                    </div>
                                    <div class="user-progress">
                                        <small
                                            class="fw-semibold">{{ number_format($expireTodayWorkPermitLetters->count(), 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Work Permit Letters Statistics -->

            <!-- Work Permit Letters Graph -->
            <div class="col-12 col-lg-7 order-1 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="m-0 me-2">Grafik SIK</h5>
                    </div>
                    <div class="card-body px-0">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                <div class="d-flex p-4 pt-3">
                                    <div>
                                        <p class="mb-2 mt-1">Total Keseluruhan SIK</p>
                                        <h6 class="text-muted">{{ number_format($allWorkPermitLetters, 0, ',', '.') }} SIK</h6>
                                    </div>
                                </div>
                                <div id="workPermitLettersGraph" class="mt-3"></div>
                                <div class="d-flex justify-content-center pt-5 gap-2">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                class="bx bx-collection"></i></span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total SIK 3 bulan terakhir</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">{{ number_format(collect($lettersPerMonth)->sum('total'), 0, ',', '.') }} SIK</h6>
                                            <small class="text-success fw-semibold">
                                                &nbsp;
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Work Permit Letters Graph -->
        </div>

        <!-- Work Permit Letter Modal -->
        <div class="modal fade" id="workPermitLetterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="workPermitLetterModalLabel">Detail SIK</h1>
                    </div>
                    <div class="modal-body">
                        <div id="loader" style="height: 300px">
                            <div class="d-flex h-100 justify-content-center align-items-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div id="content" class="d-none">
                            <div class="work-permit-letters active d-none">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>Tipe Pekerjaan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activeWorkPermitLetters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $letter->vendor->legal_name }}</td>
                                                <td>{{ $letter->workType->type }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" target="_blank" class="btn btn-primary rounded-pill">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="work-permit-letters finished d-none">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>Tipe Pekerjaan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($finishedWorkPermitLetters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $letter->vendor->legal_name }}</td>
                                                <td>{{ $letter->workType->type }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" target="_blank" class="btn btn-primary rounded-pill">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="work-permit-letters expired d-none">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>Tipe Pekerjaan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expiredWorkPermitLetters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $letter->vendor->legal_name }}</td>
                                                <td>{{ $letter->workType->type }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" target="_blank" class="btn btn-primary rounded-pill">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="work-permit-letters pending d-none">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>Tipe Pekerjaan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingWorkPermitLetters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $letter->vendor->legal_name }}</td>
                                                <td>{{ $letter->workType->type }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" target="_blank" class="btn btn-primary rounded-pill">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="work-permit-letters expire-today d-none">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>Tipe Pekerjaan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expireTodayWorkPermitLetters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $letter->vendor->legal_name }}</td>
                                                <td>{{ $letter->workType->type }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" target="_blank" class="btn btn-primary rounded-pill">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    <script>
        (function() {
            let cardColor, headingColor, axisColor, shadeColor, borderColor

            cardColor = config.colors.white
            headingColor = config.colors.headingColor
            axisColor = config.colors.axisColor
            borderColor = config.colors.borderColor

            // Work Permit Letters Statistics Chart
            // --------------------------------------------------------------------
            const workPermitLettersCount = @json($workPermitLetters->count());
            const activeWorkPermitLettersCount = @json($activeWorkPermitLetters->count());
            const finishedWorkPermitLettersCount = @json($finishedWorkPermitLetters->count());
            const expiredWorkPermitLettersCount = @json($expiredWorkPermitLetters->count());
            const pendingWorkPermitLettersCount = @json($pendingWorkPermitLetters->count());
            const expireTodayWorkPermitLettersCount = @json($expireTodayWorkPermitLetters->count());

            const chartWorkPermitLettersStatistics = document.querySelector('#workPermitLettersStatisticsChart'),
                workPermitLettersChartConfig = {
                    chart: {
                        height: 165,
                        width: 130,
                        type: 'donut',
                        events: {
                            dataPointSelection: function(event, chartContext, config) {
                                const selectedIndex = config.dataPointIndex
                                const selectedLabel = workPermitLettersChartConfig.labels[selectedIndex]
                                const labelMap = {
                                    'Aktif': 'active',
                                    'Selesai': 'finished',
                                    'Expired': 'expired',
                                    'Pending': 'pending',
                                    'Expire Hari Ini': 'expire-today'
                                }

                                const selectedStatus = labelMap[selectedLabel]

                                $('#workPermitLetterModalLabel').text(`Detail SIK: ${selectedLabel}`)
                                $('#workPermitLetterModal').modal('show')

                                setTimeout(() => {
                                    document.querySelector('#workPermitLetterModal #loader').classList.add('d-none')
                                    document.querySelectorAll('#workPermitLetterModal .work-permit-letters').forEach(el => {
                                        if (el.classList.contains(selectedStatus)) {
                                            el.classList.remove('d-none')
                                        }
                                    })
                                    document.querySelector('#workPermitLetterModal #content').classList.remove('d-none')
                                }, 500)
                            },
                        },
                    },
                    labels: ['Aktif', 'Selesai', 'Expired', 'Pending', 'Expire Hari Ini'],
                    series: [activeWorkPermitLettersCount, finishedWorkPermitLettersCount,
                        expiredWorkPermitLettersCount, pendingWorkPermitLettersCount,
                        expireTodayWorkPermitLettersCount
                    ],
                    colors: [config.colors.primary, config.colors.success, config.colors.danger, config.colors.info,
                        config.colors.warning
                    ],
                    stroke: {
                        width: 5,
                        colors: [cardColor]
                    },
                    dataLabels: {
                        enabled: false,
                        formatter: function(val, opt) {
                            return parseInt(val)
                        }
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        padding: {
                            top: 0,
                            bottom: 0,
                            right: 15
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    value: {
                                        fontSize: '1.5rem',
                                        fontFamily: 'Public Sans',
                                        color: headingColor,
                                        offsetY: -15,
                                        formatter: function(val) {
                                            return Math.floor(parseInt(val) / workPermitLettersCount * 100) + '%'
                                        }
                                    },
                                    name: {
                                        offsetY: 20,
                                        fontFamily: 'Public Sans'
                                    },
                                    total: {
                                        show: true,
                                        fontSize: '0.8125rem',
                                        color: axisColor,
                                        formatter: function(w) {
                                            return '100%'
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            if (typeof chartWorkPermitLettersStatistics !== undefined && chartWorkPermitLettersStatistics !== null) {
                const statisticsChart = new ApexCharts(chartWorkPermitLettersStatistics, workPermitLettersChartConfig)
                statisticsChart.render()
            }

            // Work Permit Letters Graph Chart
            // --------------------------------------------------------------------
            const workPermitLettersGraphLabel = @json($lettersPerMonth->pluck('month'));
            const workPermitLettersGraphSeries = @json($lettersPerMonth->pluck('total'));
            const workPermitLettersGraphSeriesAverage = Math.floor(workPermitLettersGraphSeries.reduce((sum, val) => sum + val, 0) / workPermitLettersGraphSeries.length);

            const workPermitLettersGraphEl = document.querySelector('#workPermitLettersGraph'),
                workPermitLettersGraphConfig = {
                    series: [{
                        name: 'Total',
                        data: [workPermitLettersGraphSeriesAverage].concat(workPermitLettersGraphSeries)
                    }],
                    chart: {
                        height: 215,
                        parentHeightOffset: 0,
                        parentWidthOffset: 0,
                        toolbar: {
                            show: false
                        },
                        type: 'area'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    legend: {
                        show: false
                    },
                    markers: {
                        size: 6,
                        colors: 'transparent',
                        strokeColors: 'transparent',
                        strokeWidth: 4,
                        discrete: [{
                            fillColor: config.colors.white,
                            seriesIndex: 0,
                            dataPointIndex: 7,
                            strokeColor: config.colors.primary,
                            strokeWidth: 2,
                            size: 6,
                            radius: 8
                        }],
                        hover: {
                            size: 7
                        }
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: shadeColor,
                            shadeIntensity: 0.6,
                            opacityFrom: 0.5,
                            opacityTo: 0.25,
                            stops: [0, 95, 100]
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 3,
                        padding: {
                            top: -20,
                            bottom: -8,
                            left: -10,
                            right: 8
                        }
                    },
                    xaxis: {
                        categories: ['-'].concat(workPermitLettersGraphLabel),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: true,
                            style: {
                                fontSize: '13px',
                                colors: axisColor
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        },
                        min: Math.min(...workPermitLettersGraphSeries),
                        max: Math.max(...workPermitLettersGraphSeries),
                        tickAmount: 4
                    }
                }
            if (typeof workPermitLettersGraphEl !== undefined && workPermitLettersGraphEl !== null) {
                const workPermitLettersGraph = new ApexCharts(workPermitLettersGraphEl, workPermitLettersGraphConfig)
                workPermitLettersGraph.render()
            }
        })()

        document.querySelector('#workPermitLetterModal').addEventListener('hidden.bs.modal', e => {
            document.querySelector('#workPermitLetterModal #loader').classList.remove('d-none')
            document.querySelectorAll('#workPermitLetterModal .work-permit-letters').forEach(el => {
                el.classList.add('d-none')
            })
            document.querySelector('#workPermitLetterModal #content').classList.add('d-none')
        })
    </script>
@endpush