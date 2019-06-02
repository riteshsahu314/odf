{{--<reply :attributes="{{ $reply }}" inline-template v-cloak>--}}
{{--    <div id="reply-{{ $reply->id }}" class="card my-4">--}}
{{--        <div class="card-header">--}}
{{--            <div class="level">--}}
{{--                <h5 class="flex">--}}
{{--                    <a href="{{ route('profile', $reply->owner) }}">--}}
{{--                        {{ $reply->owner->name }}--}}
{{--                    </a> said {{ $reply->created_at->diffForHumans() }}...--}}
{{--                </h5>--}}

{{--                @if (auth()->check())--}}
{{--                    <div>--}}
{{--                        <favorite :reply="{{ $reply }}"></favorite>--}}
{{--    --}}{{--                    <form method="post" action="/replies/{{ $reply->id }}/favorites">--}}
{{--    --}}{{--                        {{ csrf_field() }}--}}
{{--    --}}{{--                        <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>--}}
{{--    --}}{{--                            {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}--}}
{{--    --}}{{--                        </button>--}}
{{--    --}}{{--                    </form>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card-body">--}}
{{--            <div v-if="editing">--}}
{{--                <div class="form-group">--}}
{{--                    <textarea v-model="body" class="form-control"></textarea>--}}
{{--                </div>--}}

{{--                <button class="btn btn-sm btn-primary" @click="update">Update</button>--}}
{{--                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>--}}
{{--            </div>--}}
{{--            <div v-else v-text="body"></div>--}}
{{--        </div>--}}

{{--        @can ('update', $reply)--}}
{{--            <div class="card-footer level">--}}
{{--                <button class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>--}}
{{--                <button class="btn btn-danger btn-sm mr-2" @click="destroy">Delete</button>--}}
{{--                <form method="post" action="/replies/{{ $reply->id }}">--}}
{{--                    {{ csrf_field() }}--}}
{{--                    {{ method_field('DELETE') }}--}}

{{--                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        @endcan--}}
{{--    </div>--}}
{{--</reply>--}}
