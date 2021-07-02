<?php


namespace App\Services\Post;


use App\Models\Post;

interface PostServiceConstruct
{
    /**
     * 投稿を保存
     * @param $request
     * @return Post 投稿
     */
    public function storePost($request): Post;

}
