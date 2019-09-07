<?php

namespace App\Http\Controllers;

use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminThreadsController extends Controller
{
    /**
     * AdminThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('admin.threads.index', compact('threads'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($channelId, Thread $thread)
    {
        return view('admin.threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $channelId, Thread $thread)
    {
        $request->validate([
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
            'channel_id' => 'required|exists:channels,id',
            'locked' => 'required'
        ]);

        $request['slug'] = Str::slug($request->title);

        $thread->update($request->all());

        return redirect()->route('admin.threads.index')->with('flash', 'Thread has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->delete();

        return redirect()
            ->route('admin.threads.index')
            ->with('flash', 'Thread has been deleted successfully.');
    }
}
