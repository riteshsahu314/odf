@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom mb-3">
                    <avatar-form :user="{{ $profileUser }}"></avatar-form>
                </div>
                @forelse($activities as $date => $activity)
                    <h3 class="border-bottom">{{ $date }}</h3>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                        {{-- $activity variable within the partial is nothing but $record --}}
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>There is not activity to show.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
