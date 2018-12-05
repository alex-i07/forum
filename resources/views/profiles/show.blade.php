@extends ('layouts.app')

@section('content')
    <div class="container">
        <h3>
            {{$profileUser->name}}
            <small>since {{$profileUser->created_at->diffForHumans()}}</small>
        </h3>
        <hr>

        @foreach($threads as $thread)
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="#">{{$thread->title}}</a>
                        </span>
                        <span>
                            {{$thread->created_at->diffForHumans()}}
                        </span>
                    </div>

                </div>

                <div class="card-body">
                    {{$thread->body}}
                </div>
            </div>
        @endforeach

        {{$threads->links()}}

    </div>
@endsection