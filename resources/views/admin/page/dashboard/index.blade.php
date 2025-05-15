@extends('admin.main.app')
@section('content')
    <div class="row">
        <div class="col-xxl-12 col-lg-12 order-first">
            <div class="row row-cols-xxl-4 row-cols-1">

                @if (Auth::user()->role_id == 1)
                @php
                    $earningsChange = $data['thisweeksReport']['earnings_change'];
                    $earningsClass = $earningsChange >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                    $earningsIcon = $earningsChange >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line';

                    $ordersChange = $data['thisweeksReport']['orders_change'];
                    $ordersClass = $ordersChange >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                    $ordersIcon = $ordersChange >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line';

                    $customersChange = $data['thisweeksReport']['customers_change'];
                    $customersClass = $customersChange >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                    $customersIcon = $customersChange >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line';

                    $productsChange = $data['thisweeksReport']['products_change'];
                    $productsClass = $productsChange >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                    $productsIcon = $productsChange >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line';
                @endphp

                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="vr rounded bg-secondary opacity-50" style="width: 4px;"></div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted fs-14 text-truncate">Total Earnings</p>
                                    <h4 class="fs-22 fw-semibold mb-3">Rs.<span class="counter-value"
                                            data-target="{{ $data['thisweeksReport']['earnings'] }}">0</span></h4>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="badge {{ $earningsClass }} mb-0">
                                            <i class="{{ $earningsIcon }} align-bottom"></i>
                                            {{ $earningsChange }} %
                                        </h5>

                                        <p class="text-muted mb-0">than last week</p>
                                    </div>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-secondary-subtle text-secondary rounded fs-3">
                                        <i class="ph-wallet"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="vr rounded bg-info opacity-50" style="width: 4px;"></div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted fs-14 text-truncate">Orders</p>
                                    <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value"
                                            data-target="{{ $data['thisweeksReport']['orders'] }}">0</span> </h4>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="badge {{ $ordersClass }} mb-0">
                                            <i class="{{ $ordersIcon }} align-bottom"></i>
                                            {{ $ordersChange }} %
                                        </h5>

                                        <p class="text-muted mb-0">than last week</p>
                                    </div>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ph-storefront"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="vr rounded bg-warning opacity-50" style="width: 4px;"></div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted fs-14 text-truncate">Customers</p>
                                    <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value"
                                            data-target="{{ $data['thisweeksReport']['customers'] }}">0</span> </h4>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="badge {{ $customersClass }} mb-0">
                                            <i class="{{ $customersIcon }} align-bottom"></i>
                                            {{ $customersChange }} %
                                        </h5>

                                        <p class="text-muted mb-0">than last week</p>
                                    </div>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ph-user-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="vr rounded bg-primary opacity-50" style="width: 4px;"></div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted fs-14 text-truncate">Products</p>
                                    <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value"
                                            data-target="{{ $data['thisweeksReport']['products'] }}">0</span> </h4>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="badge {{ $productsClass }} mb-0">
                                            <i class="{{ $productsIcon }} align-bottom"></i>
                                            {{ $productsChange }} %
                                        </h5>

                                        <p class="text-muted mb-0">than last week</p>
                                    </div>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ph-sketch-logo"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- order status Of This Week --}}
                @if (Auth::user()->role_id == 1)
                    <div class="col-xxl-6 col-lg-6">
                        <div class="card-title">Order Status Summary <span class="text-muted fs-14 fw-normal">(This
                                Week)</span></div>
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <canvas id="orderStatusChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                @endif

                @if (Auth::user()->role_id == 1)
                {{-- Top Selling Categories This Week --}}
                <div class="col-xxl-6 col-lg-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Top Selling Categories<span class="text-muted fs-14 fw-normal">(This
                                Week)</h4>
                        </div>
                        <div class="card-body">
                            <div id="multiple_radialbar"
                                data-colors='["--tb-primary", "--tb-danger", "--tb-success", "--tb-secondary"]'
                                class="apex-charts" dir="ltr"></div>
                            <div class="row g-3">
                                @foreach ($data['topSellingCategories'] as $item)
                                    <div class="col-md-4">
                                        <div class="card text-center border-dashed mb-0">
                                            <div class="card-body">
                                                <i class="bi bi-square-fill text-primary me-1 fs-11"></i>
                                                {{ $item->name }}({{ $item->total }})
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div><!--end row-->
                        </div>
                    </div> <!-- .card-->
                </div>
                @endif


            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('orderStatusChart').getContext('2d');
        const orderChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
                datasets: [{
                    label: 'Orders by Status',
                    data: [
                        {{ $data['totalOrders']['pending'] }},
                        {{ $data['totalOrders']['processing'] }},
                        {{ $data['totalOrders']['completed'] }},
                        {{ $data['totalOrders']['cancelled'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.7)', // Pending
                        'rgba(54, 162, 235, 0.7)', // Processing
                        'rgba(75, 192, 192, 0.7)', // Completed
                        'rgba(153, 102, 255, 0.7)' // Cancelled
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>

    {{-- radial chart For Most Sales Categories --}}
    <script>
        let topSellingCategories = @json($data['topSellingCategories']);

        // Extract category names and their totals
        let labels = topSellingCategories.map(item => item.name);
        let series = topSellingCategories.map(item => parseInt(item.total));
        let totalSales = series.reduce((a, b) => a + b, 0);

        let chartRadialbarMultipleColors = getChartColorsArray("multiple_radialbar");

        if (chartRadialbarMultipleColors) {
            let options = {
                series: series,
                chart: {
                    height: 300,
                    type: 'radialBar',
                },
                sparkline: {
                    enabled: true
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                label: 'Sales',
                                formatter: function() {
                                    return totalSales;
                                }
                            }
                        }
                    }
                },
                labels: labels,
                colors: chartRadialbarMultipleColors,
                legend: {
                    show: false,
                    fontSize: '16px',
                    position: 'bottom',
                    labels: {
                        useSeriesColors: true,
                    },
                    markers: {
                        size: 0
                    },
                },
            };

            let chart = new ApexCharts(document.querySelector("#multiple_radialbar"), options);
            chart.render();
        }
    </script>
@endpush
