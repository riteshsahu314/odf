@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.channels.update', $channel) }}" method="post">
        @csrf
        @method('PATCH')

        @include('validation-errors')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $channel->name) }}" placeholder="Enter name" required>
        </div>

        <button type="submit" class="btn btn-primary float-left mr-3">Update Channel</button>
    </form>

    <form action="{{ route('admin.channels.destroy', $channel) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger float-left">Delete Channel</button>
    </form>

    <a href="{{ URL::previous() }}">
        <input type="button" class="btn btn-secondary float-right" value="Back">
    </a>
@endsection
