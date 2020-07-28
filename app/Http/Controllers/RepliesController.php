<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Services\SpamService;
use App\Thread;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

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
//        return redirect($thread->path());
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => request('body')]);

        return response([], 201);
    }

    public function destroy(Reply $reply)
    {
//        dd($reply->user_id, auth()->user()->id);
//        if ($reply->user_id != auth()->user()->id)  return response([], 403);

        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response([], 204);
        }

        return back();
    }
}
