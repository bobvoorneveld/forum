<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInFormTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_user_may_not_add_replies() {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();
        
        $this->post($thread->path() .'/replies', []);
        
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads() {
        $this->withoutExceptionHandling();

        $this->be(factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        
        $reply = factory('App\Reply')->make();

        $this->post($thread->path() .'/replies', $reply->toArray());
        
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}