<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{

    /**
     * Subscribe authorized users to a given thread.
     *
     * @param $channelId
     * @param Thread $thread
     */
    public function store($channelId, Thread $thread)
    {
        return $thread->subscribe();
    }

    /**
     * Unsubscribe a user from a thread.
     *
     * @param $channelId
     * @param Thread $thread
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unSubscribe();
    }
}
