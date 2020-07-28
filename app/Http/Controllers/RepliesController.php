<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Inspections\SpamService;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Return all replies for a given thread in a json format.
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * @param $channel_id
     * @param Thread $thread
     * @param SpamService $spamService
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store($channel_id, Thread $thread, SpamService $spamService)
    {
//        Auth::attempt(['email' => 'alena@renner.org', 'password' => 'secret']);

        $this->validate(request(), ['body' => 'required']);

        $spamService->detect(request('body'));

        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->user()->id
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return redirect()->back();
    }

    /**
     * @param Reply $reply
     * @param SpamService $spamService
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Reply $reply, SpamService $spamService)
    {
        $this->authorize('update', $reply);

        $spamService->detect(request('body'));

        $reply->update(['body' => request('body')]);

        return response([], 201);
    }

    /**
     * @param Reply $reply
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response([], 204);
        }

        return back();
    }
}
