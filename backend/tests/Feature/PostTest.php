<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testtop()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPostsIndex()
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
    }

    public function testPostsShow()
    {
        $response = $this->get('/posts/10');

        $response->assertStatus(200);
    }

    public function testPostsCreate__logout()
    {
        $response = $this->get('/posts/create');

        $response->assertStatus(302);
    }
    public function testPostsCreate__login()
    {
        $user = factory(User::class, 'default')->create();
        $this->actingAs($user);
        $response = $this->get('/posts/create');

        $response->assertStatus(200);
    }

    public function testPostsStore__logout()
    {
        $response = $this->post('/posts');

        $response->assertStatus(302);
    }
    public function testPostsStore__login()
    {
        $user = factory(User::class, 'default')->create();
        $this->actingAs($user);
        $response = $this->post('/posts');

        $response->assertStatus(302);
    }

    public function testPostsEdite__logout()
    {
        $response = $this->get('/posts/10/edit');

        $response->assertStatus(302);
    }

    public function testPostsUpdatee__logout()
    {
        $response = $this->put('/posts/10');

        $response->assertStatus(302);
    }

    public function testPostsDeletee__logout()
    {
        $response = $this->delete('/posts/10');

        $response->assertStatus(302);
    }
}
