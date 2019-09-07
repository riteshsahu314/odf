<?php

namespace App\Http\Controllers;

use App\ThreadSubscription;
use Illuminate\Http\Request;

class AdminSubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = ThreadSubscription::latest()->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ThreadSubscription  $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThreadSubscription $threadSubscription)
    {
        $threadSubscription->delete();

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('flash', 'Subscription has been deleted successfully!');
    }
}
