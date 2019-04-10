@extends ('layouts.app')

@section('content')
    <div class="container">
        <h3>
            {{$profileUser->name}}
            <small>since {{$profileUser->created_at->diffForHumans()}}</small>
        </h3>
        <hr>

        @forelse($activities as $date => $activity)
            <h3 class="pb-2 mt-4 mb-2 border-bottom">{{$date}}</h3>
            @foreach($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include ("profiles.activities.{$record->type}", ['activity' => $record])
                @endif
            @endforeach

        @empty
            <p>There is no activity for you yet</p>
        @endforelse

    </div>
@endsection