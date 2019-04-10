@component('profiles.activities.activity')

    @slot('heading')
        {{--check if reply was deleted--}}
        @if($activity->subject->favorited !== null)
            <a href="{{$activity->subject->favorited->path()}}">
                {{$profileUser->name}} favorited a reply
            </a>
        @else
            <span>{{$profileUser->name}} favorited a reply</span>
        @endif
        {{--        replied to <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a>--}}
    @endslot

    @slot('body')
        {{$activity->subject->favorited->body ?? 'No data'}}
    @endslot

@endcomponent