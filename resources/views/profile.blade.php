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
                <h3>Hello, <strong>Asad</strong>!</h3>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="d-flex row border shadow rounded-2 p-5 w-75">
            <div class="col">
                <form action="">
                    <div class="p-5">
                        <!-- <div>
                            <p>Enter your current password :</p>
                            <input type="password" name="" id="">
                        </div> <br>
                        <div>
                            <p>Enter new password :</p>
                            <input type="password" name="" id="">
                        </div> <br>
                        <div>
                            <p>Confirm new password :</p>
                            <input type="password" name="" id="">
                        </div> <br> -->

                    </div>
                </form>
            </div>
            <div class="col">
                <form action="">
                    <h5>Change Password</h5> <br>
                    <div>
                        <p>Enter your current password :</p>
                        <input type="password" name="" id="">
                    </div> <br>
                    <div>
                        <p>Enter new password :</p>
                        <input type="password" name="" id="">
                    </div> <br>
                    <div>
                        <p>Confirm new password :</p>
                        <input type="password" name="" id="">
                    </div> <br>
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn-secondary-db">Cancel</button>
                        <button class="btn-primary-db">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </section>




@endsection