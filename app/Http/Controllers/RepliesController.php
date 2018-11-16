<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channel_id
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channel_id, Thread $thread)
    {
//        Auth::attempt(['email' => 'alena@renner.org', 'password' => 'secret']);

        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back();
//        return redirect($thread->path());
    }
}
