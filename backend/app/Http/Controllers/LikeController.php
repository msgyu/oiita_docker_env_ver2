<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DetailedSearch;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // values
        $tag_btn_value = $request->input('tag_btn');
        $all_posts_count = DB::table('posts')->count();

        // keyword
        $keyword = $request->input('search');
        if ($tag_btn_value !== null) {
            $keyword = "#{$tag_btn_value}";
        }

        // query
        $query = Post::withCount('likes')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->where('likes.user_id', '=', Auth::id());
        $posts = DetailedSearch::DetailedSearch($query, $keyword, $request);
        $all_posts_count = DB::table('posts')->count();

        return view('likes.index', compact('posts', 'all_posts_count', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(like $like)
    {
        //
    }

    public function like_product(Request $request)
    {
        if (Auth::check()) {
            $user = auth()->user();
            $post = Post::find($request->input('post_id'));
            $likes_count = $post->likes_count;
            if ($request->input('like_exist') == 0) {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
                $likes_count->update(['likes_count' => ++$likes_count->likes_count]);
            } elseif ($request->input('like_exist')  == 1) {
                Like::where('post_id', "=", $post->id)
                    ->where('user_id', "=", $user->id)
                    ->delete();
                if ($likes_count->likes_count != 0) {
                    $likes_count->update(['likes_count' => --$likes_count->likes_count]);
                }
            }
        }
        return  $request->input('like_exist');
    }
}
