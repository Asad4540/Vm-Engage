@extends('layouts.app')
@section('pageTitle', 'Dashboard')
@section('content')

    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Clients Detail</h1>
                <p class="cd-subtitle">Clients List</p>
            </div>
            <div class="search-container">
                <form id="search-form">
                    <input type="text" name="search" id="search" class="search-prop" placeholder="search..." />
                    <i class="bi bi-search"></i>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center gap-2">
            <a href="{{ route('dashboard') }}">
                <button class="btn-secondary-db">
                    <i class="bi bi-x-square"></i>
                    Clear Search
                </button>
            </a>
            <button class="btn-primary-db " data-bs-toggle="modal" data-bs-target="#addClientModal">
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
                        <th class="px-5">Client Name</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Last activity</th>
                        @auth
                            @if (auth()->user()->role_id == 1 || 3)
                                <th>Action</th>
                            @endif
                        @endauth
                    </tr>
                </thead>

                <tbody id="client-container">
                    @include('partials.client_tbody', ['clients' => $clients])
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination gap-2">
                {{-- Previous Page Link --}}
                @if ($clients->hasPages())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $clients->previousPageUrl() }}" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                    <li class="page-item {{ $clients->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($clients->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $clients->nextPageUrl() }}" aria-label="Next">
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

    <!--Add Client Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="addClientModal">Client Onboarding</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Add Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Client Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter client name">
                        </div>

                        <!-- Upload Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Client Logo</label>
                            <div class="border rounded-3 px-2 py-1">
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <i class="bi bi-image fs-6 text-muted"></i><br>
                                    <p class="text-muted mb-0">Upload Image</p>
                                </div>
                                <input type="file" name="logo" id="upload" class="form-control mt-2"
                                    accept="image/png, image/jpeg">
                            </div>
                            <small class="text-muted">Accepted formats: JPG, PNG | Max file size: 5MB | pix : 40x40</small>
                        </div>


                        <!-- Client Details -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Client Details</label>
                            <textarea class="form-control" name="details" rows="4"
                                placeholder="Enter client details"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-control" required id="">
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="paused">Paused</option>
                                <option value="completed">Completed</option>

                            </select>

                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-primary-db fw-semibold">Save</button>
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

    </script>
@endpush