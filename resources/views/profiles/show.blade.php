@extends ('layouts.app')

@section('content')
    <div class="container">
        <h3>
            {{$profileUser->name}}
            <small>since {{$profileUser->created_at->diffForHumans()}}</small>
        </h3>
        <hr>

        @foreach($activities as $date => $activity)
            @foreach($activity as $record)
                {{--<div class="card">--}}
                {{--<div class="card-header">--}}
                {{--<div class="level">--}}
                {{--<span class="flex">--}}

            <h3 class="pb-2 mt-4 mb-2 border-bottom">{{$date}}</h3>

                @include ("profiles.activities.{$record->type}", ['activity' => $record])

            @endforeach


            {{--<a href="#">--}}
            {{--{{$thread->title}}--}}
            {{--</a>--}}
            {{--</span>--}}
            {{--<span>--}}
            {{--                            {{$thread->created_at->diffForHumans()}}--}}
            {{--</span>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--<div class="card-body">--}}
            {{--                    {{$thread->body}}--}}
            {{--</div>--}}
            {{--</div>--}}
        @endforeach

        {{--        {{$threads->links()}}--}}

    </div>
@endsection