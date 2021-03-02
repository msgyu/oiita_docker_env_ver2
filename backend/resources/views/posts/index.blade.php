@extends('layouts.app')

@section('content')
@if(!Auth::check())
<div id="login-wrapper" class="row">
  <div class="col-sm-7 top-head">
    <h1 class="top-head_h1 text-white"><b>How developers code is here.</b></h1>
    <p class="top-head_text text-white">Oiitaは、エンジニアリングに関する知識を記録・共有するためのサービスです。コードを書いていて気づいたことや、自分がハマったあの仕様について、他のエンジニアと知見を共有しましょう ;)</p>
  </div>
  <div class="col-5 d-none d-md-block">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <table>
        <tr>
          <th>ユーザ名</th>
          <td><input type="text" class="form-control" placeholder="Oiita" size="50" value="{{ old('email') }}" name="username" required autofocus></td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td><input type="email" class="form-control" placeholder="oiita@oiita.com" size="50" name="email" required></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" class="form-control" name="password" required size="50"></td>
        </tr>
        <tr>
          <th></th>
          <td><input type="submit" value="ログイン" class="form-control"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
@endif
<div class="top-wrapper">
  @include('parts.detaile-search')
  <div class="posts-wrapper col-md-6">
    <div class="posts-nav">
      <ul class="posts-nav_ul">
        <li class="active">
          <a href="">
            すべて
            <span class="badge">{{ $all_posts_count }}</span>
          </a>
        </li>
        @auth
        <li>
          <a href="{{ route('likes.index')}}">
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
    @include('parts.posts_index')

    @else
    <p>「{{ $keyword }}」に一致する記事は見つかりませんでした。</p>
    @endif
    <div class="paginate_wrapper">
      {{ $posts->links() }}
    </div>
  </div>
</div>
@endsection