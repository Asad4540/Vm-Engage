@extends('layouts.app')
@section('pageTitle', 'Campaigns')
@section('content')

    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Ads Campaigns</h1>
                <p class="cd-subtitle">Pages / Campaigns</p>
            </div>
            <div class="search-container">
                <form id="search-form">
                    <input type="text" name="search" id="search" class="search-prop" placeholder="search..." />
                    <i class="bi bi-search post"></i>
                </form>
            </div>
        </div>
        <div class="mt-3">
            <div class="d-flex justify-content-end align-items-center ">
                <form action="{{ route('campaigns.export') }}" method="GET">
                    <button type="submit" class="d-flex btn-primary-db align-items-center rounded-pill report-btn">
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
                </form>
            </div>
        </div>
    </section>

    <section>
        <div class="mt-3">
            <table class="table table-hover table-border">
                <thead>
                    <tr>
                        <!-- <th class="px-4">Ad Preview</th> -->
                        <th >Ad Name</th>
                        <th>Status</th>
                        <th>Campaign ID</th>
                        <th>Campaign Type</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="campaigns-container">
                    @include('partials.client_campaign_tbody', ['campaigns' => $campaigns])
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination gap-2">
                {{-- Previous Page Link --}}
                @if ($campaigns->hasPages())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $campaigns->previousPageUrl() }}" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($campaigns->getUrlRange(1, $campaigns->lastPage()) as $page => $url)
                    <li class="page-item {{ $campaigns->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($campaigns->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $campaigns->nextPageUrl() }}" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
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
                    url: '{{ route("client-campaign") }}',
                    type: 'GET',
                    data: { search: value },
                    success: function (data) {
                        $('.campaigns-container').html(data);
                    },
                    error: function () {
                        console.log("Search request failed.");
                    }
                });
            }, 300); // 300ms delay
        });

    </script>
@endpush