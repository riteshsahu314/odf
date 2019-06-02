<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;

class RepliesController extends Controller
{


    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Persist a new reply (Only accepting ajax calls)
     *
     * @param $channelId
     * @param Thread $thread
     * @param CreatePostRequest $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        // authorize that user can create reply
//            $this->authorize('create', new Reply);
//        if (Gate::denies('create', new Reply)) {
//            return response(
//                'You are posting too frequently. Please take a break. :)', 422
//            );
//        }

//            $this->validate(request(), ['body' => ['required', new SpamFree]]);

        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');


//        if (request()->expectsJson()) {
//            return $reply->load('owner');
//        }

//        return back()->with('flash', 'Your reply has been left.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => ['required', new SpamFree]]);

        $reply->update(request(['body']));
        //        $reply->update(['body' => request('body')]);

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

//        if ($reply->user_id != auth()->id()) {
//            return response([], 403);
//        }

        $reply->delete();

        // if ajax request
        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        }

        return back();
    }
}
