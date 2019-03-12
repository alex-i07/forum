<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function it_records_activity_when_a_test_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->user()->id,
            'subject_id'   => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /**
     * @test
     */

    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /**
     * @test
     */

    public function it_fetches_a_feed_for_any_user()
    {
        //Given we have a thread
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->user()->id], 2);

//        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]); //does not update date for some reason
        $earlierActivity = auth()->user()->activity()->first();
        $earlierActivity->created_at = Carbon::now()->subWeek();
        $earlierActivity->save();

        //When we fetch their feed
        $feed = Activity::feed(auth()->user(), 50);

//        dd($feed->toArray());

        //Then, it should be returned in a proper format
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
