<?php

namespace App\Http\Controllers;

use App\User;
use App\Channel;

class UserNotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Channel $channel, User $user)
    {
        return auth()->user()->notifications()->whereNull('read_at')->get();
    }

    public function destroy(User $user, $notification)
    {
        auth()->user()->notifications()->findOrFail($notification)->markAsRead();
    }
}
