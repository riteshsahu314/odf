<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // updates
        $updates['users_count'] = User::whereDate('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $updates['replies_count'] = Reply::whereDate('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $updates['threads_count'] = Thread::whereDate('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $updates['channels_count'] = Channel::whereDate('created_at', '>=', Carbon::now()->startOfWeek())->count();

        $rows = Reply::whereDate('created_at', '>', Carbon::now()->subWeek())
            ->selectRaw('MONTHNAME(created_at) as month, DAY(created_at) as day, count(*) as replies_count')
            ->groupBy('day', 'month')
            ->get();

        foreach ($rows as $row) {
            $replies_data[$row->month . ' ' . $row->day] = $row->replies_count;
        }

        return view('admin.index', compact('updates', 'replies_data'));
    }
}
