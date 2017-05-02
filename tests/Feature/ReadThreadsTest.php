<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
      parent::setUp();
      $this->thread = factory('App\Thread')->create();
    }

    /** @test **/
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
          ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_all_threads()
    {

        $this->get('/threads/' . $this->thread->id)
          ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_replies_associated_with_a_thread()
    {
      // Given wehave a thread
      // And that thread includes replies
      $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
      // When we visit a thread password_get_info
      // Then we shpuld see the replies
      $response = $this->get('/threads/' . $this->thread->id)
        ->assertSee($reply->body);

    }
}
