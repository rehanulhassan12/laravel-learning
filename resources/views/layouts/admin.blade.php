<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <span class="navbar-brand">Admin Dashboard</span>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link">Logout</button>
                </form>
            @endauth
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link text-center">
                <span class="brand-text font-weight-light">School System</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                        @auth
                            @if (optional(auth()->user())->canAccessScreen('users'))
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            @endif

                            @if (optional(auth()->user())->canAccessScreen('school_groups'))
                                <li class="nav-item">
                                    <a href="{{ route('school_groups.index') }}"
                                        class="nav-link {{ request()->is('school-groups*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-layer-group"></i>
                                        <p>School Groups</p>
                                    </a>
                                </li>
                            @endif

                            @if (optional(auth()->user())->canAccessScreen('schools'))
                                <li class="nav-item">
                                    <a href="{{ route('schools.index') }}"
                                        class="nav-link {{ request()->is('schools*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-school"></i>
                                        <p>Schools</p>
                                    </a>
                                </li>
                            @endif

                            @auth
                                @if (auth()->user()->isAdmin() && auth()->user()->canAccessScreen('roles'))
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}"
                                            class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-user-shield"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                @endif
                            @endauth
                            @auth
                                @if (auth()->user()->isAdmin() && auth()->user()->canAccessScreen('roles'))
                                    <li class="nav-item">
                                        <a href="{{ route('screens.index') }}"
                                            class="nav-link {{ request()->is('screens*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-user-shield"></i>
                                            <p>Screens</p>
                                        </a>
                                    </li>
                                @endif
                            @endauth

                            @if (optional(auth()->user())->canAccessScreen('classes'))
                                <li class="nav-item">
                                    <a href="{{ route('classes.index') }}"
                                        class="nav-link {{ request()->is('classes*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chalkboard"></i>
                                        <p>Classes</p>
                                    </a>
                                </li>
                            @endif
                        @endauth

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

</body>

</html>
