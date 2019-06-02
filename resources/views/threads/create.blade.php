@extends('layouts.app')

@section('header')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        <form action="/threads" method="post">
                        {{ csrf_field() }}

                        <!-- Channel_id Form Input -->
                            <div class="form-group">
                                <label for="channel_id">Choose a channel:</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($channels as $channel)
                                        <option
                                            value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Title Form Input -->
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                       id="title" required>
                            </div>

                            <!-- Body Form Input -->
                            <div class="form-group">
                                <label for="body">Body</label>
                                {{--                                <textarea class="form-control" name="body" id="body" rows="8" required>{{ old('body') }}</textarea>--}}
                                <wysiwyg-editor name="body"></wysiwyg-editor>
                            </div>

                            <div class="g-recaptcha mb-3" data-sitekey="{{ config('services.recaptcha.key') }}"></div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
