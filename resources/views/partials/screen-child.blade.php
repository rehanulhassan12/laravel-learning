@php
    $childRoute = $child->route_name && Route::has($child->route_name) ? route($child->route_name) : '#';
    $hasChildren = $child->children->count() > 0;
@endphp

<li class="nav-item {{ $hasChildren ? 'has-treeview' : '' }}">
    <a href="{{ $childRoute }}"
        class="nav-link {{ $child->route_name && request()->routeIs($child->route_name) ? 'active' : '' }}">
        <i class="{{ $hasChildren ? 'far fa-circle nav-icon' : 'far fa-dot-circle nav-icon' }}"></i>
        <p>
            {{ $child->name }}
            @if ($hasChildren)
                <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>

    @if ($hasChildren)
        <ul class="nav nav-treeview">
            @foreach ($child->children as $grand)
                @include('partials.screen-child', ['child' => $grand])
            @endforeach
        </ul>
    @endif
</li>
