@extends('layouts.app')
@section('pageTitle', 'Dashboard')
@section('content')

    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Main Dashboard</h1>
                <p class="cd-subtitle">Pages / Dashboard</p>
            </div>
            <a href="{{ route('profile')}}" class="d-flex justify-content-end">
              <img src="images/profile3.png" class="profile-section" alt="">
            </a>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="col-8 border border-2 px-0 mt-5">
                <div class="d-flex mb-4">
                    <div class="linechart clicks-tab "> <i class="bi bi-check2-square mx-1"></i>Total Clicks <br>
                        <span class="d-flex justify-content-center px-5 fw-bold">{{number_format($totalClicks) }}</span>
                    </div>
                    <div class="linechart impressions-tab"><i class="bi bi-check2-square mx-1"></i>Total Impressions <br>
                        <span
                            class="d-flex justify-content-center px-5 fw-bold">{{ number_format($totalImpressions)}}</span>
                    </div>
                </div>
                <div class="px-3 mb-4">
                    <canvas id="campaignChart" height="140"></canvas>
                </div>
            </div>
            <div class="col-4 mt-5 px-5">
                <div class="border border-2 p-2 total-ads-color d-flex justify-content-around align-items-center">
                    <div><img src="images/line-chart.png" alt=""></div>
                    <div>
                        <div class="fw-bolder fs-4 text-center">{{number_format($totalAds) }}</div>
                        <div class="fw-semibold fs-6">Total Ads</div>
                    </div>
                </div><br>
                <div class="border border-2 px-4 pt-3 ">
                    <p class="db-heading-country mb-4">Total Users by Country</p>
                    <ul class="list-unstyled">
                        @foreach($topCountries as $item)
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $item['country'] }}</span>
                                    <span>{{ $item['percentage'] }}%</span>
                                </div>
                                <div style="background-color: #e9ecef; height: 10px; border-radius: 5px; overflow: hidden;">
                                    <div style="width: {{ $item['percentage'] }}%; background-color: #5a92f2; height: 100%;">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
    </section>
@endsection

@push('pagescript')
    <script>
        let delayTimer;
        $('#search').on('keyup', function () {
            clearTimeout(delayTimer);

            let value = $(this).val();

            delayTimer = setTimeout(function () {
                $.ajax({
                    url: '{{ route("dashboard") }}',
                    type: 'GET',
                    data: { search: value },
                    success: function (data) {
                        $('#client-container').html(data);
                    },
                    error: function () {
                        console.log("Search request failed.");
                    }
                });
            }, 300); // 300ms delay
        });

        //Line chart

        // Raw data from Laravel
        const chartData = @json($campaignData);

        // Helper to get month name (e.g., "January", "February")
        const getMonthName = (dateStr) => {
            const date = new Date(dateStr);
            return date.toLocaleString('en-GB', { month: 'short' });
        };

        // Group data by month and accumulate clicks & impressions
        const monthlyData = {};

        chartData.forEach(item => {
            const month = getMonthName(item.timestamp);

            if (!monthlyData[month]) {
                monthlyData[month] = { clicks: 0, impressions: 0 };
            }

            monthlyData[month].clicks += item.clicks;
            monthlyData[month].impressions += item.impressions;
        });

        // Convert grouped object to arrays

        const labels = chartData.map(item => item.month);
        const clicksData = chartData.map(item => item.clicks);
        const impressionsData = chartData.map(item => item.impressions);


        const ctx = document.getElementById('campaignChart').getContext('2d');

        const campaignChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // ['January', 'February', ...]
                datasets: [
                    {
                        label: 'Clicks',
                        data: clicksData,
                        borderColor: '#e94ce6',
                        backgroundColor: 'rgba(233, 76, 230, 0.1)',
                        tension: 0.4,
                        fill: false,
                        borderDash: [15, 5]
                    },
                    {
                        label: 'Impressions',
                        data: impressionsData,
                        borderColor: '#5a92f2',
                        backgroundColor: 'rgba(90, 146, 242, 0.1)',
                        tension: 0.4,
                        fill: false,
                        borderDash: [15, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        labels: {
                            color: '#333',
                            boxWidth: 12
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#666' }
                    },
                    x: {
                        ticks: { color: '#666' }
                    }
                }
            }
        });

    </script>
@endpush