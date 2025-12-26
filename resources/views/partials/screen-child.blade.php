@php
    $hasChildren = $screen->children->count() > 0;

    $route = $screen->route_name && Route::has($screen->route_name) ? route($screen->route_name) : '#';
@endphp

<li class="nav-item {{ $hasChildren ? 'has-treeview' : '' }}">
    <a href="{{ $hasChildren ? 'javascript:void(0)' : $route }}"
        class="nav-link {{ !$hasChildren && request()->routeIs($screen->route_name) ? 'active' : '' }}">

        <i class="nav-icon {{ $screen->icon ?? 'fa fa-circle' }}"></i>
        <p>
            {{ $screen->name }}
            @if ($hasChildren)
                <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>

    @if ($hasChildren)
        <ul class="nav nav-treeview">

            {{-- clickable parent inside submenu --}}
            @if ($screen->route_name)
                <li class="nav-item">
                    <a href="{{ $route }}"
                        class="nav-link {{ request()->routeIs($screen->route_name) ? 'active' : '' }}">
                        <i class="fa fa-dot-circle nav-icon"></i>
                        <p>{{ $screen->name }}</p>
                    </a>
                </li>
            @endif

            @foreach ($screen->children as $child)
                @include('partials.screen-child', ['screen' => $child])
            @endforeach

        </ul>
    @endif
</li>
