@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('validation-errors')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter new password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm new password">
        </div>

        <div class="form-group">
            <label for="avatar">Avatar:</label>
            <input name="avatar" type="file" id="avatar" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary float-left mr-3">Create User</button>
    </form>
    <a href="{{ URL::previous() }}">
        <input type="button" class="btn btn-secondary float-right" value="Back">
    </a>
@endsection
