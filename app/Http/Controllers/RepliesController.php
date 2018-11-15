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

    public function store(Thread $thread)
    {
//        Auth::attempt(['email' => 'alena@renner.org', 'password' => 'secret']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back();
//        return redirect($thread->path());
    }
}
