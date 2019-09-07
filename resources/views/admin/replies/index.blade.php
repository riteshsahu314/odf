@extends('layouts.admin')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            All Replies List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" data-order="[[ 5, &quot;desc&quot; ]]" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thread ID</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Thread ID</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($replies as $reply)
                        <tr>
                            <td>{{ $reply->id }}</td>
                            <td>{{ $reply->thread_id }}</td>
                            <td>{{ $reply->user_id }}</td>
                            <td>{{ $reply->owner->name }}</td>
                            <td>{{ $reply->created_at->diffForHumans() }}</td>
                            <td>{{ $reply->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('admin.replies.edit', $reply) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.replies.destroy', $reply) }}" method="post">
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
