@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.replies.update', $reply) }}" method="post">
        @csrf
        @method('PATCH')

        @include('validation-errors')

        <div class="form-group">
            <label for="body">Body</label>
            <wysiwyg-editor name="body" value="{{ old('body', $reply->body) }}"></wysiwyg-editor>
        </div>

        <button type="submit" class="btn btn-primary float-left">Update Reply</button>
    </form>

    <form action="{{ route('admin.replies.destroy', $reply) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger float-right">Delete Reply</button>
    </form>
@endsection
