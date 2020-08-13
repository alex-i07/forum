<div class="card">
    <div class="card-header">Forum threads</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @forelse($threads as $thread)
            <article>
                <div class="level">
                    <div class="flex">
                        <h4>
                            <a href="{{$thread->path()}}">
                                @if($thread->hasUpdatesFor(auth()->user()))
                                    <strong>{{$thread->title}}</strong>
                                @else
                                    {{$thread->title}}
                                @endif
                            </a>
                        </h4>

                        <h6><strong>Created by: {{$thread->creator->name}}</strong></h6>
                    </div>

                    <strong><a href="{{$thread->path()}}">{{$thread->replies_count}} {{str_plural('reply', $thread->replies_count)}}</a></strong>

                </div>

                <div class="body">{{$thread->body}}</div>

                <hr>
            </article>
        @empty
            <p>There are no articles yet.</p>
        @endforelse
    </div>
</div>