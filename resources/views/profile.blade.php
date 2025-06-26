@extends('layouts.app')
@section('pageTitle', 'About')
@section('content')

    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Profile</h1>
                <p class="cd-subtitle">Pages / Profile</p>
            </div>
            <div class="d-flex justify-content-end align-items-center gap-2">
                <h4>Hello, <strong>{{ Str::before(Auth::user()->name, ' ')}}</strong>!</h4>
                <img src="images/profile3.png" class="profile-section" alt=""
                    onclick="window.location.href='{{ route('profile') }}'">
            </div>
        </div>
    </section>

    <section class="mt-4">
        
            <div class="shadow rounded-2 p-5" style="width:35%">

                <div class="text-center">
                    <form method="POST" action="{{ route('profile.change-password') }}">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <img src="images/profile-icon.png" alt="" style="width:20%">
                        </div><br>
                        <h4>{{ Auth::user()->name }}</h4>
                        <hr>
                        <h5>Change Password</h5> <br>
                        <center>
                            <div>
                                <input type="password" placeholder="Enter your current password " class="w-75 form-control"
                                    id="" name="current_password" required> <br>

                                <input type="password" placeholder="Enter new password " class="w-75 form-control" id=""
                                    name="new_password" required> <br>

                                <input type="password" class="w-75 form-control" id="" name="new_password_confirmation"
                                    placeholder="Confirm new password " required>
                            </div>
                        </center> <br><br>

                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn-secondary-db">Cancel</button>
                            <button class="btn-primary-db">Save</button>
                        </div>
                    </form>
                </div>

            </div>
          
    </section>




@endsection