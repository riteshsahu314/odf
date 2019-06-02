<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }

//    /**
//     * @param User $user
//     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
//     */
//    protected function getActivity(User $user)
//    {
//        return $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function ($activity) {
//            return $activity->created_at->format('Y-m-d');
//        });
//    }
}
