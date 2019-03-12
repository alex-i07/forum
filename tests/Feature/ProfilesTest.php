<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_see_a_profile()
    {
        $this->withoutExceptionHandling();  //without this test passes even if there is not ProfilesController@show method

        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /**
     * @test
     */

    public function profile_displays_all_thread_created_by_associated_user()
    {
        $this->signIn();

//        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => auth()->user()->id]);

        $this->get("/profiles/" . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
