<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DetailedSearch;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
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
        $query = Post::with(['likes', 'tags', 'user']);
        $posts = DetailedSearch::DetailedSearch($query, $keyword, $request);
        return view('posts.index', compact('posts', 'all_posts_count', 'keyword'));
    }

    public function my_posts(Request $request)
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
        $query = Post::where("posts.user_id", "=", Auth::user()->id)->withCount('likes');
        $posts = DetailedSearch::DetailedSearch($query, $keyword, $request);
        return view('posts.my_posts', compact('posts', 'all_posts_count', 'keyword'));
    }

    /**
     * @return Application|Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function create()
    {

        if (!Auth::check()) {
            return back()->with('flash_message', '投稿するにはログインする必要があります');
        }
        return view('posts.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return back()->with('flash_message', '投稿するにはログインする必要があります');
        }
        $params = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|string',
        ]);

        $params['user_id'] = Auth::id();
        $post = Post::create($params);
        $post->likes_count()->create();
        $tags = $request->tags;

        if (count($tags) !== 0) {
            foreach ($tags as $tag_params) {
                if (!empty($tag_params)) {
                    $tag = Tag::firstOrCreate(['name' => $tag_params]);
                    $post->tags()->attach($tag);
                }
            };
        }
        return redirect()->route('posts.show', compact('post'))->with('flash_message', '投稿しました');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!Auth::check()) {
            return view('posts.show', compact('post'));
        }
        $user = Auth::user();
        $like = DB::table('likes')
            ->where([
                ['post_id', '=', $post->id],
                ['user_id', '=', $user->id]
            ])
            ->get();
        return view('posts.show', compact('post', 'like'));
    }

    /**
     * @param $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return back()->with('flash_message', '編集するにはログインする必要があります');
        }
        $user = Auth::user();
        $post = Post::find($id);

        if ($user->id !== $post->user_id) {
            return back()->with('flash_message', '投稿者でなければ編集できません');
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(Request $request, post $post)
    {
        if (!Auth::check()) {
            return back()->with('flash_message', '編集するにはログインする必要があります');
        }
        $user = Auth::user();

        if ($user->id !== $post->user_id) {
            return back()->with('flash_message', '投稿者でなければ編集できません');
        }

        $params = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|string',
        ]);

        $post->fill($params)->save();
        $tags = $request->tags;
        $post->tags()->detach();

        if (count($tags) !== 0) {
            foreach ($tags as $tagParams) {
                if (!empty($tagParams)) {
                    $tag = Tag::firstOrCreate(['name' => $tagParams]);
                    $post->tags()->attach($tag);
                }
            };
        }


        return redirect()->route('posts.show', compact('post'))->with('flash_message', '更新しました');
    }

    /**
     * @param Post $post
     * @return Application|RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(post $post)
    {
        if (!Auth::check()) {
            return back()->with('flash_message', '削除するにはログインする必要があります');
        }
        if ($post->doesntExist()) {
            return redirect(route('root'))->with('flash_message', 'すでに存在しません');
        }
        $user = Auth::user();
        if ($user->id !== $post->user_id) {
            return back()->with('flash_message', '投稿者でなければ削除できません');
        }
        $post->tags()->detach();
        $post->likes_count()->delete();
        $post->delete();
        return redirect(route('root'))->with('flash_message', '削除されました');
    }
}
