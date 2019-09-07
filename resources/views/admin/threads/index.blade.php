@extends('layouts.admin')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            All Threads List
        </div>
{{--        <pre>@dd($threads)</pre>--}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" data-order="[[ 6, &quot;desc&quot; ]]" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Title</th>
{{--                        <th>Body</th>--}}
                        <th>Replies Count</th>
                        <th>Locked</th>
                        <th>Created at</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Title</th>
{{--                        <th>Body</th>--}}
                        <th>Replies Count</th>
                        <th>Locked</th>
                        <th>Created at</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($threads as $thread)
                        <tr>
                            <td>{{ $thread->id }}</td>
                            <td>{{ $thread->user_id }}</td>
                            <td>{{ $thread->creator->name }}</td>
                            <td>{{ $thread->title }}</td>
{{--                            <td>{{ $thread->body }}</td>--}}
                            <td>{{ $thread->replies_count }}</td>
                            <td>{{ $thread->locked ? 'Yes' : 'No' }}</td>
                            <td>{{ $thread->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('admin.threads.edit', [$thread->channel, $thread]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.threads.destroy', [$thread->channel, $thread]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Updated at {{ \Carbon\Carbon::now('Asia/Kolkata')->toDayDateTimeString() }}</div>
    </div>
@endsection
