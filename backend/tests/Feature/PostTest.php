<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\post;
use App\User;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // トップ画面の表示をテスト
    public function testtop()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // 投稿一覧が表示されることをテスト
    public function testPostsIndex()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

    // 投稿の詳細画面が表示されることをテスト
    public function testPostsShow()
    {
        $user = factory(User::class, 'default')->create();
        $post = factory(Post::class, 'default')->create();
        $response = $this->get(route('posts.show', $post));
        $response->assertStatus(200);
    }
}
