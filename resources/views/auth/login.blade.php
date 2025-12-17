{{-- @extends('layouts.admin') --}}

{{-- @section('content') --}}
<div class="card col-md-4 mx-auto mt-5">
    <div class="card-header">
        <h3>Login</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn btn-primary w-100">Login</button>
        </form>
        <p class="mt-3 text-center">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </p>
    </div>
</div>
{{-- @endsection --}}
