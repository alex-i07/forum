<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->thread = factory(Thread::class)->create();
    }

    public function test_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /**
     * @test
     */
    public function a_thread_can_add_a_reply()
    {
        $array = ([
            'body'    => 'Foobar',
            'user_id' => 1,
        ]);

//        dd($array);

        $this->thread->addReply($array);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * @test
     */

    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /**
     * @test
     */

    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $thread = $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /**
     * @test
     */

    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        //user with Id of 1 subscribes to a thread

        $userId = 1;

        $thread->subscribe($userId);

        // Then we should be able to fetch all threads the user has subscribed to

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /**
     * @test
     */

    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');

        $userId = 1;

        $thread->unSubscribe($userId);

        $this->assertEquals(0, $thread->subscriptions()->count());
    }

    /**
     * @test
     */

    public function thread_knows_if_it_is_subscribed_to()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
