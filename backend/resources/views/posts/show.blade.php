@extends('layouts.app')

@section('content')
<div class="post-page-wrapper">
  <div class="post-wrapper">
    <div class="post-header">
      <ul class="post-header_ul-left">
        <li><img class="user-icon" width="32px" height="32px" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ"></li>
        <li class="user-name">{{ $post->user->name }}</li>
        <li class="date">{{ $post->created_at }}</li>
      </ul>
      @can('update_post')
      <ul class="post-header_ul-right">
        <li>
          <a href="{{ route('posts.edit', $post->id) }}" class="edit-pass">
            <span>
              <i class="fas fa-pencil-alt"></i>
              編集する
            </span>
          </a>
        </li>
        <li>
          <div class="dropdown show">
            <a class="dropdown-toggle setting" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span><i class="fas fa-cog"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="dropdownMenuLink">
              <form class="dropdown-item trash-form p-0" style="display: inline-block;" method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')

                <button class="delete-button" onclick="return confirm('本当に削除しますか？')">
                  <span class="trash-form_btn"><i class="far fa-trash-alt "></i></span>
                  <span>削除</span>
                </button>
              </form>
            </div>
          </div>
        </li>
      </ul>
      @endcan
    </div>
    <div class="post-title"> {{ $post->title }}</div>
    @if($post->tags)
    <div class="post-tags" style="display:inline-flex">
      @foreach ($post->tags as $tag)
      <div>
        <form action="{{ route('posts.index')}}" method="GET">
          <button class="post-tag" name="tag_btn" value="{{ optional($tag)->name }}">{{ optional($tag)->name }}</button>
        </form>
      </div>
      @endforeach
    </div>
    @endif
    @auth
    <div class="btn-warapper">
      @if(count($like) > 0)
      <div class="like">
        <button id="like_btn" post_id="{{ $post->id }}" like_exist="1" style="color:#fff; background: #55c500">
          <span class="like_btn__span">LGTM</span>
          <span class="like_btn__count">{{ count($post->likes) }}</span>
        </button>
      </div>
      @else
      <div class="like">
        <button id="like_btn" post_id="{{ $post->id }}" like_exist="0">
          <span class="like_btn__span">LGTM</span>
          <span class="like_btn__count">{{ count($post->likes) }}</span>
        </button>
      </div>
      @endif
    </div>
    @endauth
    @guest
    <div class="btn-warapper">
      <div class="like">
        <div class="like_btn" post_id="{{ $post->id }}" like_exist="1">
          <span>LGTM</span>
          <span>{{ count($post->likes) }}</span>
        </div>
      </div>
    </div>
    @endguest
    <div class="post-body">{{$post->body}}</div>
  </div>
</div>
@endsection
