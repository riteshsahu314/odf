@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.threads.update', [$thread->channel, $thread]) }}" method="post">
    @csrf
    @method('PATCH')

    @include('validation-errors')

    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="channel">Channel</label>
            <select class="form-control" id="channel" name="channel_id">
                @foreach($channels as $channel)
                    <option value="{{ $channel->id }}" {{ $channel->id == $thread->channel->id ? 'selected' : '' }}>
                        {{ $channel->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="locked">Locked</label>
            <select class="form-control" name="locked" id="locked">
                <option value="1" {{ $thread->locked ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $thread->locked ? '' : 'selected' }}>No</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $thread->title) }}" placeholder="Enter title">
    </div>

    <div class="form-group">
        <label for="body">Body</label>
        <wysiwyg-editor name="body" value="{{ old('body', $thread->body) }}"></wysiwyg-editor>
    </div>

    <button type="submit" class="btn btn-primary float-left">Update Thread</button>
</form>

<form action="{{ route('admin.threads.destroy', [$thread->channel, $thread]) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger float-right">Delete Thread</button>
</form>
@endsection
