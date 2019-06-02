{{--Editing the question--}}
<div class="card mb-3" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" v-model="form.title" class="form-control" placeholder="Thread title">
        </div>
    </div>

    <div class="card-body">
        <!--  Form Input -->
        <div class="form-group">
            <wysiwyg-editor v-model="form.body"></wysiwyg-editor>
{{--            <textarea class="form-control" rows="10" v-model="form.body"></textarea>--}}
        </div>
    </div>

    <div class="card-footer">
        <div class="level">
{{--            <button class="btn btn-secondary btn-sm" @click="editing = true" v-show="! editing">Edit</button>--}}
            <button class="btn btn-primary btn-sm mr-2" @click="update">Update</button>
            <button class="btn btn-secondary btn-sm" @click="resetForm">Cancel</button>

            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="post" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{--Viewing the question--}}
<div class="card mb-3" v-else>
    <div class="card-header">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}"
                 alt="{{ $thread->creator->name }}"
                 height="25"
                 width="25"
                 class="mr-3">

            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted: <span v-text="title"></span>
            </span>
        </div>
    </div>

    <div class="card-body" v-html="body"></div>

    @can('update', $thread)
        <div class="card-footer">
            <button class="btn btn-secondary btn-sm" @click="editing = true" v-if="authorize('owns', thread)">Edit</button>
        </div>
    @endcan
</div>
