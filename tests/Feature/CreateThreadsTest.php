<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

//        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */

    public function guest_may_not_create_thread()
    {
        $this->withExceptionHandling();

        $this->get('threads/create')
            ->assertRedirect('login');


        $this->post('threads')
            ->assertRedirect('login');
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        //Sign user in
//        $this->actingAs(create('App\User'));

        $this->signIn();

        //When we hit the endpoing to create a new thread
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        //Then, when we visit a thread page
        $response = $this->get($response->headers->get('Location'));

        //We should see a new thread
        $response->assertSee($thread->title)->assertSee($thread->body);
    }

    /**
     * @test
     */

    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */

    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */

    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => 99])
            ->assertSessionHasErrors('channel_id');
    }

    protected function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}