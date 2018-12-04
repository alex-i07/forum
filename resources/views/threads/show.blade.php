@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="m-2">
                    {{$replies->links()}}
                </div>


                @if (auth()->check())
                    <div class="row">
                        <div class="col-md-8">
                            <form method="post" action="{{$thread->path() . '/replies'}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="body">Body:</label>
                                    <textarea id="body" name="body" rows="5" class="form-control"
                                              placeholder="Have something to say?"></textarea>
                                </div>

                                <button type="submit" class="btn btn-outline-primary">Post a message</button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-center">Please, <a href="{{route('login')}}"> sign in</a> to participate in this
                        discussion</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">

                    </div>

                    <div class="card-body">
                        This thread was publiched {{$thread->created_at->diffForHumans()}} by <a
                                href="#">{{$thread->creator->name}}</a> and currentry
                        has {{$thread->replies_count}} {{str_plural('comment', $thread->replies_count)}}.
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection