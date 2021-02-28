@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  @include('parts.detaile-search')
  <div class="posts-wrapper col-md-6">
    <div class="posts-nav">
      <ul class="posts-nav_ul">
        <li>
          <a href="{{ route('posts.index') }}">
            すべて
            <span class="badge">{{ $all_posts_count }}</span>
          </a>
        </li>
        @auth
        <li class="active">
          <a href="">
            LGTM済み
            <span class="badge">{{ count(Auth::user()->likes)}}</span>
          </a>
        </li>
        <li>
          <a href="{{ route('my_posts')}}">
            投稿記事
            <span class="badge">{{ count(Auth::user()->posts)}}</span>
          </a>
        </li>
        @endauth
      </ul>
    </div>
    @if(count($posts) !== 0)
    @include('parts.posts_index', ['posts' => $posts] )
    @else
    <p>「{{ $keyword }}」に一致する記事は見つかりませんでした。</p>
    @endif
    <div class="paginate_wrapper">
      {{ $posts->links() }}
    </div>
  </div>
</div>
@endsection