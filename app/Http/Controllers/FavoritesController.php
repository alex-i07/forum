<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
//        Favorite::create([
//            'user_id' => auth()->user()->id,
//            'favorited_id' => $reply->id,
//            'favorited_type' => get_class($reply)
//        ]);

       $reply->favorite();

        return back();
//        $reply->favorites()->create(['user_id' => auth()->user()->id]);
    }
}
