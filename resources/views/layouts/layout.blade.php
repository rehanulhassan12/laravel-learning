<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System Dashboard</title>

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
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <span class="navbar-brand ml-2">School System</span>

            @auth
                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
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
                @php
                    use App\Models\Screen;

                    $roleIds = auth()->user()->roles()->pluck('roles.id')->toArray();

                    // Get all screens user has access to (flattened)
                    $menu = Screen::with('roles')
                        ->get()
                        ->filter(function ($screen) use ($roleIds) {
                            return $screen->roles->pluck('id')->intersect($roleIds)->count() > 0 ||
                                $screen->roles->count() === 0;
                        });
                @endphp

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        @foreach ($menu as $screen)
                            @php
                                $route =
                                    $screen->route_name && Route::has($screen->route_name)
                                        ? route($screen->route_name)
                                        : '#';
                            @endphp
                            <li class="nav-item">
                                <a href="{{ $route }}"
                                    class="nav-link {{ request()->routeIs($screen->route_name) ? 'active' : '' }}">
                                    <i class="nav-icon {{ $screen->icon ?? 'far fa-circle' }}"></i>
                                    <p>{{ $screen->name }}</p>
                                </a>
                            </li>
                        @endforeach
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

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
