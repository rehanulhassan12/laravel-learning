@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Screens</h3>
            <a href="{{ route('screens.create') }}" class="btn btn-primary btn-sm">Add Screen</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                @foreach ($screens as $screen)
                    <tr>
                        <td>{{ $screen->name }}</td>
                        <td>
                            <a href="{{ route('screens.edit', $screen->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('screens.destroy', $screen->id) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
