<div class="card-header">
    <div class="level">
        <h5 class="flex">
            <a href="{{route('profile', $reply->owner->name)}}"> {{$reply->owner->name}}</a>&nbsp;
            said {{$thread->created_at->diffForHumans()}}...
        </h5>

        @if(auth()->check())
            <form method="post" action="/replies/{{$reply->id}}/favorites">
                {{csrf_field()}}
                <button type="submit" class="btn btn-outline-success"{{$reply->isFavorited() ? 'disabled': ''}}>
                    {{$reply->getFavoritesCountAttributes()}} {{str_plural('favorite', $reply->getFavoritesCountAttributes())}}
                </button>
            </form>
        @endif

    </div>
</div>

<div class="card">
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>