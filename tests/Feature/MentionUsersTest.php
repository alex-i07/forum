<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
   public function a_user_can_mention_another_user()
   {
       $john = create(User::class, ['name' => 'JohnDoe']);

       $this->signIn($john);

       $jane = create(User::class, ['name' => 'JaneDoe']);

       $thread = create(Thread::class);

       $reply = create(Reply::class, ['body' => '@JaneDoe look at this']);

       $this->post($thread->path() . '/replies', $reply->toArray());

       $this->assertCount(1, $jane->notifications);
   }
}
