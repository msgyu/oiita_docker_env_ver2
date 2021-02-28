@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  <div class="posts-wrapper col-md-6">
    @foreach ($posts as $post)
    <div class="post-box">
      <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
      <div class="post-box_right">
        <a class="post-title" href="{{ route('posts.show', $post->id)}}">{{ $post->title }}</a>
        <div class="post-details">
          <div class="post-details_date">{{ $post->created_at }}</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection