<?php


namespace App\Services\Post;


use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostService implements PostServiceConstruct
{
    /**
     * @inheritDoc
     */
    public function storePost($request): Post
    {

        $post = Post::create([
            'title' => $request->input('title'),
            'body'  => $request->input('body'),
            'user_id' => Auth::id(),
        ]);
        $post->likes_count()->create();

        // タグの紐付け
        $tags = $request->input('tags');

        if (count($tags) !== 0) {
            foreach ($tags as $tag_params) {
                if (!empty($tag_params)) {
                    $tag = Tag::firstOrCreate(['name' => $tag_params]);
                    $post->tags()->attach($tag);
                }
            }
        }
        return $post;
    }
}
