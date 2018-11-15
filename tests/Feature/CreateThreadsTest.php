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
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }

    /**
     * @test
     */

    public function guest_may_not_see_thread_creation_form()
    {
        $this->withExceptionHandling()->get('threads/create')->assertRedirect('login');
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
        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

        //Then, when we visit a thread page
        $response = $this->get($thread->path());

        //We should see a new thread
        $response->assertSee($thread->title)->assertSee($thread->body);
    }
}