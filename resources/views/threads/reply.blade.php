
<div class="card-header"><a href="#"></a> {{$reply->owner->name}}
    said {{$thread->created_at->diffForHumans()}}...
</div>

<div class="card">
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>