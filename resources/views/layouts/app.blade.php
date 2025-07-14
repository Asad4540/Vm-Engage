<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VM ENGAGE - @yield('pageTitle')</title>
    <link href="{{ asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive-styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light main-navbar">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('dashboard') }}">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Clients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ad-campaign') }}">Ad Campaigns</a>
                            </li>
                            @auth
                                @if (auth()->user()->role_id == 1)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('users') }}">Users</a>
                                    </li>
                                @endif
                            @endauth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Logout</a>
                            </li>
                        @endif
                    @endauth

                    <!-- Client Side Navbar  -->
                    @auth
                        @if (auth()->user()->role_id == 2)
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client-campaign') }}">Ad Campaigns</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile') }}">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Logout</a>
                            </li>
                        @endif
                    @endauth

                </ul>

            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row flex-nowrap dashboard-main-container">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar-bg d-none d-lg-block">
                <div class="d-flex flex-column align-items-sm-start px-3 pt-2 min-vh-100 sticky">
                    <a href="{{ route('dashboard') }}"
                        class="d-flex align-items-center me-md-auto text-decoration-none">
                        <img src="images/main-logo.png" class="main-logo" alt=""><br>
                        <!-- <h1 class="sidebar-heading">VM Engage</h1> -->
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-sm-start sidebar-links">
                        @auth
                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)
                                <li class="nav-item px-1">
                                    <a href="{{ route('dashboard') }}"
                                        class="nav-link {{ Request::Is('dashboard*') ? 'active' : '' }} && {{ Request::Is('clients*') ? 'active' : '' }}  ">
                                        <div class="nav-link-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                                                class="bi bi-card-list" viewBox="0 0 16 16">
                                                <path
                                                    d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                                <path
                                                    d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                            </svg>
                                            <span>Clients</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('ad-campaign') }}"
                                        class="nav-link {{ Request::Is('ad-campaign*') ? 'active' : '' }} ">
                                        <div class="nav-link-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"
                                                fill="currentColor" class="">
                                                <path
                                                    d="M12.6751 19.5C10.9417 19.4097 9.47925 18.7416 8.28758 17.4958C7.09591 16.25 6.50008 14.7513 6.50008 13C6.50008 11.1944 7.13203 9.65968 8.39591 8.39579C9.6598 7.1319 11.1945 6.49996 13.0001 6.49996C14.7515 6.49996 16.2501 7.09579 17.4959 8.28746C18.7417 9.47913 19.4098 10.9416 19.5001 12.675L17.2251 11.9979C16.9904 11.0229 16.4848 10.2239 15.7084 9.601C14.932 8.97808 14.0292 8.66663 13.0001 8.66663C11.8084 8.66663 10.7883 9.09093 9.93966 9.93954C9.09105 10.7882 8.66675 11.8083 8.66675 13C8.66675 14.0291 8.97821 14.9319 9.60112 15.7083C10.224 16.4847 11.023 16.9902 11.998 17.225L12.6751 19.5ZM13.9751 23.7791C13.8126 23.8152 13.6501 23.8333 13.4876 23.8333H13.0001C11.5015 23.8333 10.0931 23.5489 8.77508 22.9802C7.45703 22.4114 6.3105 21.6395 5.3355 20.6645C4.3605 19.6895 3.58862 18.543 3.01987 17.225C2.45112 15.9069 2.16675 14.4986 2.16675 13C2.16675 11.5013 2.45112 10.093 3.01987 8.77496C3.58862 7.4569 4.3605 6.31038 5.3355 5.33538C6.3105 4.36038 7.45703 3.5885 8.77508 3.01975C10.0931 2.451 11.5015 2.16663 13.0001 2.16663C14.4987 2.16663 15.907 2.451 17.2251 3.01975C18.5431 3.5885 19.6897 4.36038 20.6647 5.33538C21.6397 6.31038 22.4115 7.4569 22.9803 8.77496C23.549 10.093 23.8334 11.5013 23.8334 13V13.4875C23.8334 13.65 23.8154 13.8125 23.7792 13.975L21.6667 13.325V13C21.6667 10.5805 20.8272 8.53121 19.148 6.85204C17.4688 5.17288 15.4195 4.33329 13.0001 4.33329C10.5806 4.33329 8.53133 5.17288 6.85216 6.85204C5.173 8.53121 4.33341 10.5805 4.33341 13C4.33341 15.4194 5.173 17.4687 6.85216 19.1479C8.53133 20.827 10.5806 21.6666 13.0001 21.6666H13.3251L13.9751 23.7791ZM22.2355 24.375L17.6042 19.7437L16.2501 23.8333L13.0001 13L23.8334 16.25L19.7438 17.6041L24.3751 22.2354L22.2355 24.375Z" />
                                            </svg>
                                            <span>Ad Campaigns</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endauth
                        @auth
                            @if (auth()->user()->role_id == 1)
                                <li>
                                    <a href="{{ route('users') }}"
                                        class="nav-link {{ Request::Is('users*') ? 'active' : '' }} ">
                                        <div class="nav-link-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27"
                                                fill="currentColor">
                                                <path
                                                    d="M13.5 13.5C12.1937 13.5 11.0755 13.0349 10.1453 12.1047C9.2151 11.1745 8.75 10.0563 8.75 8.75C8.75 7.44375 9.2151 6.32552 10.1453 5.39531C11.0755 4.4651 12.1937 4 13.5 4C14.8062 4 15.9245 4.4651 16.8547 5.39531C17.7849 6.32552 18.25 7.44375 18.25 8.75C18.25 10.0563 17.7849 11.1745 16.8547 12.1047C15.9245 13.0349 14.8062 13.5 13.5 13.5ZM4 23V19.675C4 19.0021 4.17318 18.3836 4.51953 17.8195C4.86589 17.2555 5.32604 16.825 5.9 16.5281C7.12708 15.9146 8.37396 15.4544 9.64062 15.1477C10.9073 14.8409 12.1937 14.6875 13.5 14.6875C14.8062 14.6875 16.0927 14.8409 17.3594 15.1477C18.626 15.4544 19.8729 15.9146 21.1 16.5281C21.674 16.825 22.1341 17.2555 22.4805 17.8195C22.8268 18.3836 23 19.0021 23 19.675V23H4Z" />
                                            </svg>
                                            <span>Users</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endauth


                        @auth
                            @if (auth()->user()->role_id == 2)
                                <li>
                                    <a href="{{ route('home') }}" class="nav-link {{ Request::Is('home*') ? 'active' : '' }} ">
                                        <div class="nav-link-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="26" fill="currentColor"
                                                class="bi bi-columns-gap" viewBox="0 0 16 16">
                                                <path
                                                    d="M6 1v3H1V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm14 12v3h-5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM6 8v7H1V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1zm14-6v7h-5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1z" />
                                            </svg>
                                            <span>Dashboard</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client-campaign') }}"
                                        class="nav-link {{ Request::Is('client-campaign*') ? 'active' : '' }} ">
                                        <div class="nav-link-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                                                class="">
                                                <path
                                                    d="M12.6751 19.5C10.9417 19.4097 9.47925 18.7416 8.28758 17.4958C7.09591 16.25 6.50008 14.7513 6.50008 13C6.50008 11.1944 7.13203 9.65968 8.39591 8.39579C9.6598 7.1319 11.1945 6.49996 13.0001 6.49996C14.7515 6.49996 16.2501 7.09579 17.4959 8.28746C18.7417 9.47913 19.4098 10.9416 19.5001 12.675L17.2251 11.9979C16.9904 11.0229 16.4848 10.2239 15.7084 9.601C14.932 8.97808 14.0292 8.66663 13.0001 8.66663C11.8084 8.66663 10.7883 9.09093 9.93966 9.93954C9.09105 10.7882 8.66675 11.8083 8.66675 13C8.66675 14.0291 8.97821 14.9319 9.60112 15.7083C10.224 16.4847 11.023 16.9902 11.998 17.225L12.6751 19.5ZM13.9751 23.7791C13.8126 23.8152 13.6501 23.8333 13.4876 23.8333H13.0001C11.5015 23.8333 10.0931 23.5489 8.77508 22.9802C7.45703 22.4114 6.3105 21.6395 5.3355 20.6645C4.3605 19.6895 3.58862 18.543 3.01987 17.225C2.45112 15.9069 2.16675 14.4986 2.16675 13C2.16675 11.5013 2.45112 10.093 3.01987 8.77496C3.58862 7.4569 4.3605 6.31038 5.3355 5.33538C6.3105 4.36038 7.45703 3.5885 8.77508 3.01975C10.0931 2.451 11.5015 2.16663 13.0001 2.16663C14.4987 2.16663 15.907 2.451 17.2251 3.01975C18.5431 3.5885 19.6897 4.36038 20.6647 5.33538C21.6397 6.31038 22.4115 7.4569 22.9803 8.77496C23.549 10.093 23.8334 11.5013 23.8334 13V13.4875C23.8334 13.65 23.8154 13.8125 23.7792 13.975L21.6667 13.325V13C21.6667 10.5805 20.8272 8.53121 19.148 6.85204C17.4688 5.17288 15.4195 4.33329 13.0001 4.33329C10.5806 4.33329 8.53133 5.17288 6.85216 6.85204C5.173 8.53121 4.33341 10.5805 4.33341 13C4.33341 15.4194 5.173 17.4687 6.85216 19.1479C8.53133 20.827 10.5806 21.6666 13.0001 21.6666H13.3251L13.9751 23.7791ZM22.2355 24.375L17.6042 19.7437L16.2501 23.8333L13.0001 13L23.8334 16.25L19.7438 17.6041L24.3751 22.2354L22.2355 24.375Z" />
                                            </svg>
                                            <span>Ad Campaigns</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile') }}"
                                        class="nav-link {{ Request::Is('profile*') ? 'active' : '' }} ">
                                        <div class="nav-link-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27"
                                                fill="currentColor">
                                                <path
                                                    d="M13.5 13.5C12.1937 13.5 11.0755 13.0349 10.1453 12.1047C9.2151 11.1745 8.75 10.0563 8.75 8.75C8.75 7.44375 9.2151 6.32552 10.1453 5.39531C11.0755 4.4651 12.1937 4 13.5 4C14.8062 4 15.9245 4.4651 16.8547 5.39531C17.7849 6.32552 18.25 7.44375 18.25 8.75C18.25 10.0563 17.7849 11.1745 16.8547 12.1047C15.9245 13.0349 14.8062 13.5 13.5 13.5ZM4 23V19.675C4 19.0021 4.17318 18.3836 4.51953 17.8195C4.86589 17.2555 5.32604 16.825 5.9 16.5281C7.12708 15.9146 8.37396 15.4544 9.64062 15.1477C10.9073 14.8409 12.1937 14.6875 13.5 14.6875C14.8062 14.6875 16.0927 14.8409 17.3594 15.1477C18.626 15.4544 19.8729 15.9146 21.1 16.5281C21.674 16.825 22.1341 17.2555 22.4805 17.8195C22.8268 18.3836 23 19.0021 23 19.675V23H4Z" />
                                            </svg>
                                            <span>Profile</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endauth


                        <li>
                            <a href="#" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="nav-link-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <g clip-path="url(#clip0_180_179)">
                                            <path
                                                d="M11 7L9.6 8.4L12.2 11H2V13H12.2L9.6 15.6L11 17L16 12L11 7ZM20 19H12V21H20C21.1 21 22 20.1 22 19V5C22 3.9 21.1 3 20 3H12V5H20V19Z" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_180_179">
                                                <rect width="27" height="27" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span>Logout</span>
                                </div>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    <div class="mb-4 mt-5 px-3">
                        <h5 class="mb-3">
                            @2025 VMENGAGE
                        </h5>
                        <p class="sidebar-footer mb-5 ">All Rights Reserved. <br>Made with ❤️ <br> by Vereigen Media!
                        </p>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <div class=" col bg-white main-content-section">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/jshelper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('pagescript')
    @stack('scripts')

</body>

</html>