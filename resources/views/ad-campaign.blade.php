@extends('layouts.app')
@section('pageTitle', 'Ad-Campaign')
@section('content')

    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Ads Campaign List</h1>
                <p class="cd-subtitle">Campaigns list</p>
            </div>
            <div class="search-container">
                <form id="search-form">
                    <input type="text" name="search" id="search" class="search-prop" placeholder="search..." />
                    <i class="bi bi-search"></i>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center gap-2">
            <a href="{{ route('ad-campaign') }}">
                <button class="btn-secondary-db">
                    <i class="bi bi-x-square"></i>
                    Clear Search
                </button>
            </a>
            <button class="btn-primary-db " data-bs-toggle="modal" data-bs-target="#adsDetailModal">
                <i class="bi bi-plus-square"></i>
                Add
            </button>
        </div>
    </section>

    <section>
        <div class="mt-3">
            <table class="table custom-table table-hover">
                <thead>
                    <tr>
                        <th class="px-4">Ad Preview</th>
                        <th>Client Name</th>
                        <th>Ad Name</th>
                        <th>Campaign ID</th>
                        <th>Campaign Type</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="campaigns-container">
                    @include('partials.campaign_tbody', ['campaigns' => $campaigns])
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
    </div>


    <!-- Modal -->
    <div class="modal fade" id="adsDetailModal" tabindex="-1" aria-labelledby="adsDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="adsDetailModalLabel">Ads Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('campaign.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Upload Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ad Preview image</label>
                            <div class="border rounded-3 px-2 py-1">
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <i class="bi bi-image fs-6 text-muted"></i><br>
                                    <p class="text-muted mb-0">Upload Image</p>
                                </div>
                                <input type="file" name="ad_preview" id="upload" class="form-control mt-2"
                                    accept="image/png, image/jpeg">
                            </div>
                            <small class="text-muted">Accepted formats: JPG, PNG | Max file size: 5MB | pix : 40x40</small>
                        </div>

                        <!-- Add Name -->
                        <div class="mb-3">
                            <label for="client_id" class="form-label fw-semibold">Select Client</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="" selected disabled>--Select--</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ad Name</label>
                            <input type="text" name="ad_name" class="form-control" value="" placeholder="Summer Sale">
                        </div>



                        <!-- Campaign ID -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Campaign ID</label>
                            <input type="text" name="campaign_id" class="form-control" value="" placeholder="CMP-102">
                        </div>

                        <!-- Campaign Type -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Campaign Type</label>
                            <input type="text" name="campaign_type" class="form-control" value="" placeholder="Banner">
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary fw-semibold px-5"
                                style="background-color: var(--button-color-primary);">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pagescript')
    <script>
        let delayTimer;
        $('#search').on('keyup', function () {
            clearTimeout(delayTimer);

            let value = $(this).val();

            delayTimer = setTimeout(function () {
                $.ajax({
                    url: '{{ route("ad-campaign") }}',
                    type: 'GET',
                    data: { search: value },
                    success: function (data) {
                        $('#campaigns-container').html(data);
                    },
                    error: function () {
                        console.log("Search request failed.");
                    }
                });
            }, 300); // 300ms delay
        });

    </script>
@endpush