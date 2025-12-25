@php
    $hasChildren = $screen->childrenRecursive->count() > 0;
    $route = $screen->route_name && Route::has($screen->route_name) ? route($screen->route_name) : '#';
@endphp

<li class="nav-item {{ $hasChildren ? 'has-treeview' : '' }}">
    <a href="{{ $route }}" class="nav-link {{ request()->routeIs($screen->route_name) ? 'active' : '' }}">
        <i class="nav-icon {{ $screen->icon ?? 'far fa-circle' }}"></i>
        <p>
            {{ $screen->name }}
            @if ($hasChildren)
                <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>

    @if ($hasChildren)
        <ul class="nav nav-treeview">
            @foreach ($screen->childrenRecursive as $child)
                @include('partials.sidebar-item', ['screen' => $child])
            @endforeach
        </ul>
    @endif
</li>
