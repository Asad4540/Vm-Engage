@extends('layouts.app')
@section('pageTitle', 'About')
@section('content')

    <section>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="cd-title">Profile</h1>
                <p class="cd-subtitle">Pages / Profile</p>
            </div>
            <div>
                <h3>Hello, <strong>User</strong>!</h3>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <center>
            <div class="border shadow rounded-2 p-5 w-50">

                <div class="text-center">
                    <form action="">
                        <div>
                            <img src="images/profile-icon.png" alt="" class="w-25">
                        </div><br>
                        <h3>User Name</h3> <br>
                        <hr>
                        <h5>Change Password</h5> <br>
                        <div>
                            <p>Enter your current password :</p>
                            <input type="password" class="w-50" name="" id="">
                        </div> <br>
                        <div>
                            <p>Enter new password :</p>
                            <input type="password" class="w-50" name="" id="">
                        </div> <br>
                        <div>
                            <p>Confirm new password :</p>
                            <input type="password" class="w-50" name="" id="">
                        </div> <br><br>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn-secondary-db">Cancel</button>
                            <button class="btn-primary-db">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        <center>
    </section>




@endsection