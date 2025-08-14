@extends('layouts.app')
@section('pageTitle', 'Ad-Campaigns')
@section('content')


    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Ads Campaigns</h1>
                <p class="cd-subtitle">Pages / Campaigns</p>
            </div>

        </div>
        <div class="mt-3">
            <div class="d-flex justify-content-end align-items-center ">
                <button id="downloadPdfBtn" class="d-flex btn-primary-db align-items-center rounded-pill report-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                        <g clip-path="url(#clip0_1_4580)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.94462 0.00218201H17.6336L25.8453 8.5615V25.2094C25.8453 27.2949 24.1581 28.9822 22.0798 28.9822H7.94462C5.85911 28.9822 4.17188 27.2949 4.17188 25.2094V3.77493C4.17184 1.68942 5.85907 0.00218201 7.94462 0.00218201Z"
                                fill="#E5252A" />
                            <path opacity="0.302" fill-rule="evenodd" clip-rule="evenodd"
                                d="M17.626 0.00218201V8.49632H25.8449L17.626 0.00218201Z" fill="white" />
                            <path
                                d="M8.36475 21.6249V16.3315H10.6168C11.1744 16.3315 11.6162 16.4835 11.9492 16.7949C12.2823 17.0991 12.4489 17.5118 12.4489 18.026C12.4489 18.5401 12.2823 18.9529 11.9492 19.257C11.6162 19.5684 11.1744 19.7205 10.6168 19.7205H9.71888V21.6249H8.36475ZM9.71888 18.5691H10.4648C10.6675 18.5691 10.8268 18.5256 10.9355 18.4243C11.0441 18.3301 11.102 18.1998 11.102 18.026C11.102 17.8522 11.0441 17.7219 10.9355 17.6277C10.8269 17.5263 10.6675 17.4829 10.4648 17.4829H9.71888V18.5691ZM13.0065 21.6249V16.3315H14.882C15.2513 16.3315 15.5989 16.3822 15.9247 16.4908C16.2506 16.5994 16.5475 16.7515 16.8082 16.9615C17.0689 17.1642 17.2789 17.4394 17.4309 17.787C17.5758 18.1346 17.6554 18.5329 17.6554 18.9818C17.6554 19.4236 17.5758 19.8218 17.4309 20.1694C17.2789 20.517 17.0689 20.7922 16.8082 20.9949C16.5475 21.2049 16.2506 21.357 15.9247 21.4656C15.5989 21.5742 15.2513 21.6249 14.882 21.6249H13.0065ZM14.3316 20.4736H14.7227C14.9327 20.4736 15.1282 20.4519 15.3092 20.4011C15.483 20.3505 15.6496 20.2708 15.8089 20.1622C15.9609 20.0536 16.0841 19.9015 16.1709 19.6987C16.2578 19.496 16.3013 19.257 16.3013 18.9818C16.3013 18.6994 16.2578 18.4605 16.1709 18.2577C16.0841 18.055 15.9609 17.9029 15.8089 17.7943C15.6496 17.6857 15.483 17.606 15.3092 17.5553C15.1282 17.5046 14.9327 17.4829 14.7227 17.4829H14.3316V20.4736ZM18.3361 21.6249V16.3315H22.1017V17.4829H19.6903V18.3301H21.6165V19.4742H19.6903V21.6249H18.3361Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_1_4580">
                                <rect width="28.98" height="28.98" fill="white"
                                    transform="translate(0.518066 0.00218201)" />
                            </clipPath>
                        </defs>
                    </svg>
                    <div class="d-flex align-items-center rounded-2">
                        <p class="m-2">Download Report</p>
                    </div>
                </button>
            </div>
        </div>
    </section>

    <section id="report-section">
        <section>
            <div class="row mt-4 gap-3 justify-content-center">
                <div class="col-lg-3 border border-2 rounded-3">
                    <div class="m-2 mb-3 text-center ">
                        <div>
                            <p class="client-cards-heading">Client Logo </p>
                            @if($campaign->client->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('images/client_logos/' . $campaign->client->logo) }}" alt="Ad Preview"
                                        width="300" height="auto">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                @php
                    $urlData = json_decode($campaign->url ?? '', true);
                    if (!is_array($urlData) || empty($urlData)) {
                        $urlData = [];
                    }
                @endphp

                <div class="col-lg-5 border border-2 rounded-3">
                    <div class="m-2">
                        <p class="client-cards-heading">Ads Placed on Pages</p>
                        <div class="row mx-2">
                            <div class="col-4">
                                <p class="ads-text">Tech-Properties</p>

                                <select class="form-control tech-select">
                                    <option value="">--Select--</option>
                                    @foreach ($tech_properties as $tech_property)
                                        <option value="{{ $tech_property->id }}">{{ $tech_property->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-8">
                                <p class="ads-text">URLs</p>

                                <div id="url-list">
                                    @foreach ($urlData as $index => $item)
                                        <div class="url-box mb-2" data-tech="{{ $item['tech_prop_id'] }}">
                                            <a href="{{ $item['url'] }}" target="_blank">{{ $item['url'] }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- ---------------------------------------------------------------------------------------------------   -->
                <div class="col-lg-3 border border-2 rounded-3">
                    <div class="m-2">
                        <p class="client-cards-heading">Pacing</p>


                        @php
                            $delivered = old('delivered', $campaign->delivered ?? 0);
                            $remaining = old('remaining', $campaign->remaining ?? 0);
                            $circleCircumference = 314; // 2 * π * r where r = 50
                            $deliveredOffset = $circleCircumference - ($delivered / 100 * $circleCircumference);
                            $remainingOffset = $circleCircumference - ($remaining / 100 * $circleCircumference);
                        @endphp
                        <!-- Delivered -->
                        <div class="circle-chart mx-auto my-4">
                            <svg width="120" height="120">
                                <circle cx="60" cy="60" r="50" stroke="#D8F3EE" stroke-width="12" fill="#D8F3EE" />
                                <circle cx="60" cy="60" r="50" stroke="#00b59e" stroke-width="12" fill="none"
                                    stroke-dasharray="314" stroke-dashoffset="{{ $deliveredOffset }}"
                                    stroke-linecap="round" />
                            </svg>
                            <div class="percentage">{{ round($delivered) }}%</div>
                        </div>
                        <div class="circle-label">Delivered</div>

                        <!-- Remaining -->
                        <div class="circle-chart mx-auto my-4">
                            <svg width="120" height="120">
                                <circle cx="60" cy="60" r="50" stroke="#FBF7D4" stroke-width="12" fill="#FBF7D4" />
                                <circle cx="60" cy="60" r="50" stroke="#fcd93a" stroke-width="12" fill="none"
                                    stroke-dasharray="314" stroke-dashoffset="{{ $remainingOffset }}"
                                    stroke-linecap="round" />
                            </svg>
                            <div class="percentage" name="remaining" id="remaining"
                                value="{{ old('remaining', $campaign->remaining ?? '') }}">{{ round($remaining) }}%</div>
                        </div>
                        <div class="circle-label">Remaining</div>

                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="mt-4 mx-4 border border-2 rounded-3 px-0">
                <div class="d-flex mb-2">
                    <div class="linechart clicks-tab "> <i class="bi bi-check2-square mx-1"></i>Clicks <br>
                        <span class="d-flex justify-content-center px-5 fw-bold">{{ $campaign->total_clicks }}</span>
                    </div>
                    <div class="linechart impressions-tab"><i class="bi bi-check2-square mx-1"></i>Impressions <br>
                        <span class="d-flex justify-content-center px-5 fw-bold">{{ $campaign->total_impressions }}</span>
                    </div>
                </div>
                <div class="px-3">
                    <canvas id="campaignChart" height="80"></canvas>
                </div>
            </div>
        </section>

        <section>
            <div class="row mt-4 gap-5 justify-content-center">
                <div class="col-7 px-0 h-100">
                    <table class="table table-hover custom-table" style="margin-bottom:0 !important">
                        <thead>
                            <tr>
                                <th class="px-4">Ad Preview</th>
                                <th>Size</th>
                                <th>Clicks</th>
                                <th>Impressions</th>
                            </tr>
                        </thead>
                        <tbody class="campaigns-container">
                            @php
                                // Decode the JSON arrays from the campaign
                                $adPreviews = isset($campaign) ? json_decode($campaign->single_adpreview, true) ?? [] : [];
                                $sizes = isset($campaign) ? json_decode($campaign->single_size, true) ?? [] : [];
                                $clicks = isset($campaign) ? json_decode($campaign->single_clicks, true) ?? [] : [];
                                $impressions = isset($campaign) ? json_decode($campaign->single_impressions, true) ?? [] : [];

                                // Get the maximum count of items
                                $itemCount = max(
                                    count($adPreviews),
                                    count($sizes),
                                    count($clicks),
                                    count($impressions)
                                );
                            @endphp

                            @for($i = 0; $i < $itemCount; $i++)
                                <tr>
                                    <td class="px-4">
                                        @if(!empty($adPreviews[$i]) && file_exists(public_path($adPreviews[$i])))
                                            <img src="{{ asset($adPreviews[$i]) }}" alt="Ad Preview" style="max-width: 100px;">
                                        @else
                                            <img src="https://placehold.co/100" alt="No Preview" style="max-width: 100px;">
                                        @endif
                                    </td>
                                    <td>{{ $sizes[$i] ?? 'N/A' }}</td>
                                    <td>{{ number_format($clicks[$i] ?? 0) }}</td>
                                    <td>{{ number_format($impressions[$i] ?? 0) }}</td>
                                </tr>
                            @endfor

                            @if($itemCount === 0)
                                <tr>
                                    <td colspan="4" class="text-center">No ad data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>


                <div class="col-4 border border-2 rounded-3 ">
                    <div class="m-2">
                        <p class="client-cards-heading">Devices </p>
                        <div class="w-full max-w-sm mx-auto">
                            <canvas id="deviceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="row mt-4 mx-4 justify-content-center">
                <div class="col-12 border border-2 rounded-3 ">
                    <div class="m-2">
                        <p class="client-cards-heading">User by Region </p>
                        <div class="row justify-content-between">
                            <div class="col-8">
                                <img src="{{ asset('images/map.png') }}">
                            </div>
                            <div class="col-4 mb-4">
                                <p class="text-center country-text fw-bold mb-3">Top Countries</p>
                                <ul class="list-group">
                                    @foreach($topCountries as $item)
                                        <li class="list-group-item ">
                                            <div class=" d-flex justify-content-between">
                                                <span>{{ $item['country'] }}</span>
                                                <span>{{ $item['percentage'] }}%</span>
                                            </div>
                                            <div
                                                style="background-color: #e9ecef; height: 10px; border-radius: 5px; overflow: hidden;">
                                                <div
                                                    style="width: {{ $item['percentage'] }}%; background-color: #5a92f2; height: 100%;">
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="row mt-4 mx-4 ">
                <div class="col-12 border border-2 rounded-3 ">
                    <div class="m-2">
                        <p class="client-cards-heading">Top Sites</p>
                        <table class="table table-bordered table-hover">
                            <tbody>
                                @if(!empty($top_sites) && (is_array($top_sites) || is_object($top_sites)))
                                    @foreach ($top_sites as $site)
                                        <tr>
                                            <td>
                                                <a href="{{ $site }}" target="_blank">{{ $site }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center text-muted">No sites available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </section>


    </section>


@endsection


@push('scripts')
    <script>

        //Pie chart
        document.addEventListener("DOMContentLoaded", function () {
            const deviceData = {
                labels: ['Mobile', 'Desktop'],
                datasets: [{
                    label: 'Device Usage',
                    data: [{{ $deviceData->mobile ?? 0 }}, {{ $deviceData->desktop ?? 0 }}],
                    backgroundColor: ['#00d1b2', '#3b82f6'],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            };

            const config = {
                type: 'pie',
                data: deviceData,
                options: {
                    plugins: {
                        legend: {
                            position: 'left',
                            labels: {
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let value = context.raw;
                                    let percentage = ((value / total) * 100).toFixed(2);
                                    return `${context.label}: ${percentage}%`;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(document.getElementById('deviceChart'), config);
        });


        //Tech property Dropdown
        $(document).ready(function () {
            $('.tech-select').on('change', function () {
                const selectedTech = $(this).val();

                if (selectedTech === '') {
                    // Show all URLs
                    $('.url-box').show();
                } else {
                    // Show only matching tech_prop_id
                    $('.url-box').each(function () {
                        const techId = $(this).data('tech');
                        $(this).toggle(techId == selectedTech);
                    });
                }
            });
        });


        //Line Chart

        const dates = @json(json_decode($campaign->date ?? '[]', true));
        const clicks = @json(json_decode($campaign->clicks ?? '[]', true));
        const impressions = @json(json_decode($campaign->impressions ?? '[]', true));

        const chartData = dates.map((date, index) => ({
            date: date,
            clicks: clicks[index] || 0,  // Default to 0 if no data
            impressions: impressions[index] || 0
        }));


        const validChartData = chartData.filter(item => item.date);

        const labels = validChartData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short'
            });
        });

        const clicksData = validChartData.map(item => item.clicks);
        const impressionsData = validChartData.map(item => item.impressions);

        // Create the chart
        const ctx = document.getElementById('campaignChart').getContext('2d');
        const campaignChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Clicks',
                        data: clicksData,
                        borderColor: '#e94ce6',
                        backgroundColor: 'rgba(233, 76, 230, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Impressions',
                        data: impressionsData,
                        borderColor: '#5a92f2',
                        backgroundColor: 'rgba(90, 146, 242, 0.1)',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: ${context.parsed.y}`;
                            },
                            title: function (context) {
                                return validChartData[context[0].dataIndex].date;
                            }
                        }
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

        //Js to capture Screenshot   
        document.getElementById('downloadPdfBtn').addEventListener('click', function () {
            const section = document.getElementById('report-section');
            const adName = @json($campaign->ad_name ?? 'campaign');

            html2canvas(section).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');

                // Calculate width and height
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

                // Generate file name with today's date
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                const slugifiedName = adName.replace(/\s+/g, '-').replace(/[^a-zA-Z0-9\-]/g, '').toLowerCase();
                const fileName = `${slugifiedName}-${dd}-${mm}-${yyyy}.pdf`;

                pdf.save(fileName);
            });
        });


    </script>
@endpush

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>