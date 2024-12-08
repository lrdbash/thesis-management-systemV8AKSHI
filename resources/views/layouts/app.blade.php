<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Strathmore University TMS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    @yield('styles')
</head>
<body>
    <div id="app">
        <!-- Updated Navbar -->
        <!-- Navigation Bar -->
        
                <nav class="navbar" role="navigation" aria-label="Main Navigation">
                <a class="navbar-brand text-white" href="{{ route('posts.index') }}">
    <div class="navbar-brand-content">
        <img src="{{ asset('images/School-of-Graduate-Studies-logo.png') }}" class="logo-image" alt="Logo">
        <span class="brand-title">
            Strathmore University<br>   Thesis Management System
        </span>
    </div>
</a>

   


           <!-- Centralized Links (Home and Messages) -->
           <div class="navbar-center">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">

                        <a class="nav-link text-white" href="{{ route('posts.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('messages.conversation') }}">Messages</a>
                    </li>
                    @auth
                    
                        @if(Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                        <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('charts') }}">Admin Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('calendar') }}">Events</a>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.intakes.list') }}">Intakes</a>
                            </li>
                        @elseif(method_exists(Auth::user(), 'isStudent') && Auth::user()->isStudent())
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('student.progress') }}">Student Dashboard</a>
                            </li>
                            
                        @elseif(method_exists(Auth::user(), 'isStaff') && Auth::user()->isStaff())
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('staff.supervisor.dashboard') }}">Supervisor Dashboard</a>
                            </li>
                            
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('calendar_1') }}">Calendar</a>
                        </li>  
                    @endauth
                </ul>
            </div>
            <!-- Right-side Login Links -->
            <div class="navbar-right">
                    <ul class="navbar-nav ml-auto">


                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">User Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('examiner.login') }}">Examiner Login</a>
                        </li>
                        
                        @else
                        @if(Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                            <li class="nav-item">
                               
                            </li>
                        @endif

                        @if(Auth::guard('examiner')->check())
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('examiner.dashboard') }}">Examiner Dashboard</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name ?? Auth::guard('examiner')->user()->name }}
                            </a>
                            <div class="navbar-right">
                                    <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <!-- Main Content with Sidebar for Admins -->
        
        <main class="py-4">
    <div class="container-fluid">
        <div class="row">
            @if(Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                <!-- Hamburger Menu -->
                <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>
                 <!-- Hamburger icon -->
                </div>
                <!-- Sidebar for Admin -->
                <div class="col-md-3 sidebar" id="sidebar">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Admin Menu
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                            <a href="{{ route('examiner.list') }}" class="list-group-item list-group-item-action">List of Examiners</a>
                            <a href="{{ route('examiner.register') }}" class="list-group-item list-group-item-action">Register Examiner</a>
                            <a href="{{ route('admin.student.list') }}" class="list-group-item list-group-item-action">Manage Students</a>
                        </div>
                    </div>
                </div>
                <!-- Main content area -->
                <div class="col-md-9 main-content">
                    @yield('content')
                </div>
            @else
                <!-- Main content area for non-admin users -->
                <div class="col-md-12 main-content">
                    @yield('content')
                </div>
            @endif
        </div>
    </div>
</main>

<!-- Add this script at the end of your HTML, before the closing </body> tag -->
<script>
    // Function to toggle the sidebar
function toggleSidebar() {
    var sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('collapsed');
    
    // Toggle the display of the sidebar
    if (sidebar.classList.contains('collapsed')) {
        sidebar.style.display = 'none';
    } else {
        sidebar.style.display = 'block';
    }
}

</script>
</body>
</html>
