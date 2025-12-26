@php
    // Recursive closure to check if any descendant is active
    $isChildActive = function ($screen) use (&$isChildActive, $roleIds) {
        if (request()->routeIs($screen->route_name . '.index')) {
            return true;
        }

        foreach ($screen->children as $child) {
            if ($child->roles->isEmpty() || $child->roles->pluck('id')->intersect($roleIds)->count()) {
                if ($isChildActive($child)) {
                    return true;
                }
            }
        }

        return false;
    };

    // Filter children by role
    $children = $screen->children->filter(
        fn($c) => $c->roles->isEmpty() || $c->roles->pluck('id')->intersect($roleIds)->count(),
    );

    $hasChildren = $children->count() > 0;
    $childActive = $isChildActive($screen);
    $isActive = request()->routeIs($screen->route_name . '.index');
    $route = $screen->route_name ? route($screen->route_name . '.index') : 'javascript:void(0)';
@endphp

<li class="nav-item {{ $hasChildren ? 'has-treeview' : '' }} {{ $childActive ? 'menu-open' : '' }}">
    {{-- Parent toggle (clickable only if no children) --}}
    <a href="{{ $hasChildren ? 'javascript:void(0)' : $route }}" class="nav-link {{ $isActive ? 'active' : '' }}">
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

            {{-- Parent itself as first child --}}
            @if ($screen->route_name)
                <li class="nav-item">
                    <a href="{{ route($screen->route_name . '.index') }}"
                        class="nav-link {{ $isActive ? 'active' : '' }}">
                        <i class="fa fa-dot-circle nav-icon"></i>
                        <p>{{ $screen->name }}</p>
                    </a>
                </li>
            @endif

            {{-- Recursive children --}}
            @foreach ($children as $child)
                @include('partials.screen-child', ['screen' => $child, 'roleIds' => $roleIds])
            @endforeach

        </ul>
    @endif
</li>
