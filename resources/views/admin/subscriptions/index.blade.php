@extends('layouts.admin')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            All Subscriptions List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" data-order="[[ 4, &quot;desc&quot; ]]" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Thread ID</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Thread ID</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Delete</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ $subscription->user_id }}</td>
                            <td>{{ $subscription->thread_id }}</td>
                            <td>{{ $subscription->created_at->diffForHumans() }}</td>
                            <td>{{ $subscription->updated_at->diffForHumans() }}</td>
                            <td>
                                <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="post">
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
