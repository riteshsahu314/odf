@extends('layouts.admin')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            All Channels List
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" data-order="[[ 3, &quot;desc&quot; ]]" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($channels as $channel)
                        <tr>
                            <td>{{ $channel->id }}</td>
                            <td class="w-50">{{ $channel->name }}</td>
                            <td>{{ $channel->created_at->diffForHumans() }}</td>
                            <td>{{ $channel->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('admin.channels.edit', $channel) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.channels.destroy', $channel) }}" method="post">
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
