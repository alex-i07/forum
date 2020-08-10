<?php

namespace Unit;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_fetch_most_recent_reply()
    {
        $user = create(User::class);

        create(Reply::class, ['user_id' => $user->id]);

        $lastReply = create(Reply::class, ['user_id' => $user->id]);

        $this->assertEquals($lastReply->id, $user->lastReply->id);
    }
}
