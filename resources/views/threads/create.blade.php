@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new thread</div>

                    <div class="card-body">
                        <form action="/threads" method="post">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="title">Channel:</label>
                                <select class="form-control" id="channel" name="channel_id"
                                        placeholder="Choose a channel" required>
                                    <option value="" disabled selected>Select your channel</option>
                                    @foreach(App\Channel::get() as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="title"
                                       value="{{old('title')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" id="body" name="body" placeholder="body"
                                          rows="9" required>{{old('body')}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary">Publish</button>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger" style="list-style: none;">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection