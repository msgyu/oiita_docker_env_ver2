@foreach ($posts as $post)
<div class="post-box">
  <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
  <div class="post-box_right">
    <a class="post-title" href="{{ route('posts.show', $post->id)}}">{{ $post->title }}</a>
    <div class="post-details">
      <div class="post-details_date">
        <span>{{ $post->created_at }}</span>
        <span class="lgtm">LGTM {{ count($post->likes) }}</span>
      </div>
      @if($post->tags)
      <div class="post-tags" style="display:inline-flex">
        @foreach ($post->tags as $tag)
        <div>
          @if (Route::currentRouteName() === 'likes.index')
          <form action="{{ route('likes.index')}}" method="GET">
            @elseif (Route::currentRouteName() === 'my_posts')
            <form action="{{ route('my_posts')}}" method="GET">
              @else
              <form action="{{ route('posts.index')}}" method="GET">
                @endif
                <button class="post-tag" name="tag_btn" value="{{ optional($tag)->name }}">{{ optional($tag)->name }}</button>
              </form>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</div>
@endforeach