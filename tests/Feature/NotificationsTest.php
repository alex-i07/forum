<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     *
     * @return void
     */
    public function a_notification_is_prepared_when_subscribed_thread_receives_new_reply_that_is_not_by_a_current_user()
    {
        $this->signIn();

        $user = create('App\User');

        $thread = create('App\Thread')->subscribe();

        $thread->subscribe($user->id);

        $this->assertCount(0, auth()->user()->notifications);

        //Then, each time someone left a reply...
        $thread->addReply([
            'user_id' => auth()->user()->id,
            'body' => 'Some message body here'
        ]);


        //User receives notification (push, email, etc).

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $this->assertCount(1, $user->fresh()->notifications);
    }

    /**
     * @test
     */
    public function a_user_can_fetch_unread_notifications()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some message body here'
        ]);

        $user = auth()->user()->name;

        $response = $this->getJson("profiles/{$user}/notifications")->json();

        $this->assertCount(1, $response);
    }

    /**
     * @test
     */
    public function a_user_can_mark_notifications_as_read()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some message body here'
        ]);


        //User receives notification (push, email, etc).

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $user = auth()->user()->name;

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete("profiles/{$user}/notifications/{$notificationId}");

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }
}
