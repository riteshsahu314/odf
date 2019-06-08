@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>
                    @include('threads._question')

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>

{{--                    @foreach ($replies as $reply)--}}
{{--                        @include('threads.reply')--}}
{{--                    @endforeach--}}

{{--                    {{ $replies->links() }}--}}

{{--                    @if (auth()->check())--}}
{{--                        <form method="post" action="{{ $thread->path() . '/replies' }}">--}}
{{--                        {{ csrf_field() }}--}}

{{--                        <!-- Body Form Input -->--}}
{{--                            <div class="form-group">--}}
{{--                                <textarea class="form-control" name="body" id="body"--}}
{{--                                          placeholder="Have something to say?" rows="5"></textarea>--}}
{{--                            </div>--}}

{{--                            <button type="submit" class="btn btn-primary">Post</button>--}}
{{--                        </form>--}}
{{--                    @else--}}
{{--                        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this--}}
{{--                            discussion</p>--}}
{{--                    @endif--}}
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> and currently
                                has <span
                                    v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                                {{-- <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies()->count() }} comments.--}}
                                {{-- do not do {{ $thread->replies->count() }} as it will load all replies first then count--}}
                            </p>

                            <p>
{{--                                <subscribe-button :active="{{ $thread->isSubscribedTo ? 'true' : 'false' }}"></subscribe-button>--}}
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>

                                <button class="btn btn-outline-danger"
                                        v-if="authorize('isAdmin')"
                                        @click="toggleLock"
                                        v-text="locked ? 'Unlock' : 'Lock'"
                                >
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
