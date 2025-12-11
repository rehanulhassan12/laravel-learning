@extends('layouts.app')

@section('content')


<h1>Add Users</h1>

<a href="{{route( 'users.index') }}">Back to List</a>

@if($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label>Name:</label><br>
    <input type="text" name="name" value="{{ old('name') }}"><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}"><br>
    <label>Password:</label><br>
    <input type="password" name="password"><br><br>
    <button type="submit">Save</button>
</form>

@endsection