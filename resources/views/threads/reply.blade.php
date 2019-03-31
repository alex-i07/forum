<reply-component :attributes="{{$reply}}" inline-template v-cloak>
    <div>
        <div id="reply-{{$reply->id}}" class="card-header">
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
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                        <button type="button" @click="update" class="btn btn-primary btn-sm">Updade</button>
                        <button type="button" @click="editing=false" class="btn btn-link btn-sm">Cancel</button>
                    </div>
                </div>
                <div v-else v-text="body">
{{--                    {{$reply->body}}--}}
                </div>
            </div>

            @can('update', $reply)
                <div class="card-footer level mr-1">
                        <button type="button" @click="editing=true" class="btn btn-warning btn-sm">Edit</button>

                        <button type="button" @click="destroy" class="btn btn-danger btn-sm">Delete</button>
                    {{--<form method="POST" action="/replies/{{$reply->id}}">--}}
                        {{--{{csrf_field()}}--}}
                        {{--@method('DELETE')--}}
                        {{--<button type="submit" class="btn btn-danger btn-sm"></button>--}}
                    {{--</form>--}}
                </div>
            @endcan
        </div>
    </div>
</reply-component>