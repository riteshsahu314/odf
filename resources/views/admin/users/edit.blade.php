@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.users.update', $user) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('validation-errors')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" placeholder="Enter name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" placeholder="Enter email" required>
        </div>

        <div class="form-group">
            <label for="password">Change Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter new password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm new password">
        </div>

        <div class="form-group">
            <label for="avatar">Avatar:</label>

            <div>
                <img src="{{ old('avatar_path', $user->avatar_path) }}" alt="User Avatar" class="img-fluid avatar-big mr-3">
                <input name="avatar" type="file" id="avatar" accept="image/*">
            </div>
        </div>


        <button type="submit" class="btn btn-primary float-left mr-3">Update User</button>
    </form>

    <form action="{{ route('admin.users.destroy', $user) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger float-left">Delete User</button>
    </form>

    <a href="{{ URL::previous() }}">
        <input type="button" class="btn btn-secondary float-right" value="Back">
    </a>
@endsection
