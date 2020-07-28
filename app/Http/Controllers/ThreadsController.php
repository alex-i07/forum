<?php

namespace App\Http\Controllers;

use App\Inspections\SpamService;
use App\Thread;
use App\Channel;
use App\Filters\ThreadFilters;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {

        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        //в url передаётся channel slug not id; а Laravel попытается использовать route model binding
        //который по умолчанию ищет модель в базе по id
        //нужно перезаписать метод getRouteKeyName() в модели Channel

//        if ($channel->exists) {
//
//            $threads = $channel->threads()->latest();
//
////            $channelId = Channel::where('slug', $channel)->first()->id;
////
////            $threads = Thread::where('channel_id', $channelId)->latest()->get();
//        } else {
//
//        }
//
//        if ($username = request('by')) {
//            $user = User::where('name', $username)->firstOrFail();
//
//            $threads->where('user_id', $user->id);
//        }
//
//        $threads = $threads->filter($filters)->get();

//        $thread = Thread::filter($filters)->get();
//        $threads = $this->getThreads($channel);

//        $channels = Channel::get();  //приходится то же самое писать в других методах, иначе undefined variable

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * @param Request $request
     * @param SpamService $spamService
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, SpamService $spamService)
    {
        $this->validate($request, [
            'title'      => 'required',
            'body'       => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $spamService->detect(request('body'));

        $thread = Thread::create([
            'user_id'    => auth()->user()->id,
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body')
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param    $channelId
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        if (auth()->id()) {
            auth()->user()->read($thread);
        }

        return view('threads.show', [
            'thread'  => $thread
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * @param Channel $channel
     * @param Thread $thread
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (\request()->wantsJson()) {
            return response('', 204);
        }

        return redirect('threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::with('channel')->latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

//        dd($threads->toSql());

        $threads = $threads->get();

        return $threads;
    }
}
