@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
                <div class="col-md-8">
                    <search query="{{ request('q') }}"></search>
                </div>

                <div class="col-md-4">
                    @if(count($trending))
                        <div class="card">
                            <div class="card-header">
                                Trending Threads
                            </div>
                            <ul class="list-group">
                                @foreach($trending as $thread)
                                    <li class="list-group-item">
                                        <a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
        </div>
    </div>
@endsection
