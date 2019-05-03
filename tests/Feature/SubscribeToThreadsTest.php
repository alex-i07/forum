<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */

    public function a_user_can_subscribe_to_threads()
    {
        $this->withoutExceptionHandling(); //without this test passes even if there is no ThreadSubscriptionsController@store method

        //Given we have a thread...
        $thread = create('App\Thread');

        $this->signIn();

        //and a signed user subscribes to it ...
        $this->post($thread->path() . '/subscriptions');

        //Then, each time someone left a reply...
        $thread->addReply([
            'user_id' => auth()->user()->id,
            'body' => 'Some message body here'
        ]);


        //User receives notification (push, email, etc).

//        $this->assertCount(1, auth()->user()->notifications);
    }
}