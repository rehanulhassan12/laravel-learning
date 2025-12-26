<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                @csrf
                <button class="btn btn-link">Logout</button>
            </form>
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

                    $screens = Screen::with('childrenRecursive', 'roles')
                        ->whereNull('parent_id')
                        ->get()
                        ->filter(
                            fn($s) => $s->roles->isEmpty() || $s->roles->pluck('id')->intersect($roleIds)->count(),
                        );
                @endphp

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false">
                        @foreach ($screens as $screen)
                            @include('partials.screen-child', ['screen' => $screen, 'roleIds' => $roleIds])
                        @endforeach
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
