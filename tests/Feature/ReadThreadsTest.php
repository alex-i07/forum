<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();


    }

    /*@test*/
    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);

        $response->assertSee($this->thread->title);

        $response->assertSee($this->thread->body);
    }

    /*@test*/
    public function a_user_can_see_single_test()
    {
        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertSee($this->thread->title);
    }

    /*@test*/
    public function test_a_user_can_read_replies_that_are_associated_with_thread()
    {
        $reply = factory(Reply::class)
            ->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());
//        dd($this->thread->path(), $reply->body);
        $response->assertSee($reply->body);

    }

    /**
     * @test
     */

    public function a_user_can_filter_threads_according_to_channel()
    {
        $channel = create('App\Channel');
        $threadNotInChannel = create('App\Thread');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * @test
     */

    public function a_user_can_filter_threads_by_any_username()
    {
        $user = create('App\User', ['name' => 'JohnDoe']);

        $this->signIn($user);

        $threadByJohn = create('App\Thread', ['user_id' => $user->id]);

        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /**
     * @test
     */

    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
