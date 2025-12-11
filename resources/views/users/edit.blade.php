
@extends('layouts.app')

@section('content')
<h1>Edit User</h1>
<a href="{{ route('users.index') }}">Back to List</a>

@if($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Name:</label><br>
    <input type="text" name="name" value="{{ old('name', $user->name) }}"><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email', $user->email) }}"><br>
    <label>Password (leave blank to keep current):</label><br>
    <input type="password" name="password"><br><br>
    <button type="submit">Update</button>
</form>
@endsection