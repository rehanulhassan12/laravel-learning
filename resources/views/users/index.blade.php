@extends('layouts.app')

@section('content')

<h1>Users</h1>
<a href="{{ route('users.create') }}">Add New Users</a>

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif


<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    @foreach ($users as $user )
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          <a href="{{ route('users.edit',$user->id) }}">Edit</a>
        </td>

        <td>
          <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this User?')">Delete</button>
          </form>
        </td>

    </tr>
      
    @endforeach
    </table>

@endsection