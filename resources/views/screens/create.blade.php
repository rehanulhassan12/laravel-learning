@extends('layouts.layout')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('screens.store') }}">
                @csrf

                <input name="name" placeholder="Screen Name" class="form-control" value="{{ old('name') }}">
                <input name="route_name" placeholder="Route Name" class="form-control mt-2" value="{{ old('route_name') }}">
                <input name="icon" placeholder="Icon (fas fa-users)" class="form-control mt-2"
                    value="{{ old('icon') }}">

                <select name="parent_id" class="form-control mt-2">
                    <option value="">-- Parent (optional) --</option>

                    @php
                        function renderOptions($screens, $prefix = '')
                        {
                            foreach ($screens as $screen) {
                                echo '<option value="' . $screen->id . '">' . $prefix . $screen->name . '</option>';
                                if ($screen->children->count()) {
                                    renderOptions($screen->children, $prefix . '-- ');
                                }
                            }
                        }

                        // Only top-level screens
                        renderOptions($parents);
                    @endphp
                </select>

                <button class="btn btn-primary mt-2">Save</button>
            </form>
        </div>
    </div>

@endsection
