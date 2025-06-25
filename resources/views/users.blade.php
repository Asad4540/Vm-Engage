@extends('layouts.app')
@section('pageTitle', 'Users')
@section('content')
    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Users</h1>
                <p class="cd-subtitle">All Users List</p>
            </div>
            <div class="search-container">
                <form id="search-form">
                    <input type="text" name="search" id="search" class="search-prop" placeholder="search..." />
                    <i class="bi bi-search"></i>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center gap-2">
            <a href="{{ route('users') }}">
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
                        <!-- <th >Username</th> -->
                        <th class="px-4">Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="users-container">
                    @include('partials.user_tbody', ['users' => $users])
                </tbody>
            </table>
        </div>
    </section>


    <section>
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination gap-2">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
                    <h5 class="modal-title fw-bold" id="addClientModal">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('createuser') }}" id="formcreateuser">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Alex">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="asadc4540@vm.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Set a Password</label>
                            <input type="password" class="form-control" name="password" placeholder="**********">
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


    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formEditUser">
                <div class="modal-content rounded-4 p-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="edit-user-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-role" class="form-label">Role</label>
                            <select class="form-control" id="edit-role" name="role_id" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-primary-db fw-semibold">Update User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection

@push('pagescript')
    <script>
        $("#formcreateuser").submit(function (e) {
            e.preventDefault();

            var data = $(this).serialize();
            var url = $(this).attr('action');
            var type = "POST";

            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message || 'User created successfully!');
                        $('#formcreateuser')[0].reset(); // clear form
                        setTimeout(() => location.reload(), 1500); // reload after toast
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        });

        $(document).on('click', '.delete-user', function () {
            const userId = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: `/users/${userId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') // important for CSRF
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function () {
                        toastr.error('Failed to delete user. Try again.');
                    }
                });
            }
        });

        //Edit User 
        $(document).on('click', '.edit-user', function () {
            const userId = $(this).data('id');

            $.get('/users/' + userId, function (response) {
                if (response.status === 'success') {
                    $('#edit-user-id').val(response.user.id);
                    $('#edit-name').val(response.user.name);
                    $('#edit-email').val(response.user.email);
                    $('#edit-role').val(response.user.role_id);
                    $('#editUserModal').modal('show');
                }
            });
        });

        $('#formEditUser').submit(function (e) {
            e.preventDefault();

            const userId = $('#edit-user-id').val();
            const formData = $(this).serialize();

            $.ajax({
                url: '/users/' + userId,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    if (response.status === 'success') {
                        $('#editUserModal').modal('hide');
                        toastr.success('User updated successfully');
                        location.reload(); // or update the row dynamically
                    }
                },
                error: function (xhr) {
                    toastr.error('Something went wrong');
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const userSearchUrl = "{{ route('users') }}";

        let delayTimer;

        // Use event delegation
        $(document).on('keyup', '#search', function () {
            clearTimeout(delayTimer);

            let value = $(this).val();

            delayTimer = setTimeout(function () {
                fetchUsers(value);
            }, 300);
        });

        // Clear button logic
        $(document).on('click', '#clear-search', function () {
            $('#search').val('');
            fetchUsers('');
        });

        // Reusable function
        function fetchUsers(searchValue) {
            $.ajax({
                url: '{{ route('users') }}',
                type: 'GET',
                data: { search: searchValue },
                success: function (data) {
                    $('#users-container').html(data);
                },
                error: function () {
                    console.error("Search request failed.");
                }
            });
        }
    </script>
@endpush