@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.channels.store') }}" method="post">
        @csrf

        @include('validation-errors')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
        </div>

        <button type="submit" class="btn btn-primary float-left mr-3">Create Channel</button>
    </form>

    <a href="{{ URL::previous() }}">
        <input type="button" class="btn btn-secondary float-right" value="Back">
    </a>
@endsection
