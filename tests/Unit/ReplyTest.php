<?php

namespace Tests\Unit;

use App\User;
use App\Reply;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_an_owner()
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /**
     * @test
     */
    public function it_knows_it_was_just_published()
    {
        $reply = create(Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subDay();

        $this->assertFalse($reply->wasJustPublished());
    }

    /**
     * @test
     */
    public function it_wraps_mentioned_user_in_an_anchor_tag()
    {
        $reply = create(Reply::class, ['body' => 'Hello, @JaneDoe']);

        $this->assertEquals(
            'Hello, <a href="/profiles/JaneDoe">@JaneDoe</a>',
            $reply->body
        );
    }
}
