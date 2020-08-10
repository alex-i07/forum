<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Gate;

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
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store($channel_id, Thread $thread)
    {
        if (Gate::denies('create', new Reply())) {
            return response()->json('Your are posting too frequently', 429);
        }

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);

            if (request()->expectsJson()) {
                return $reply->load('owner');
            }

            return response()->json(['status' => 'Reply was stored!'], 200);

        } catch (\Exception $e) {
            return response()->json('Spam has been detected!', 422);
        }
    }

    /**
     * @param Reply $reply
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

        try {
//            $spamService->detect(request('body'));

            $reply->update(['body' => request('body')]);

            return response([], 201);

        } catch (\Exception $e) {
            return response()->json('Spam has been detected!', 422);
        }
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
