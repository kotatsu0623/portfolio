@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <div>
    <form action="{{ route('posts.index') }}" method="GET">
      <input type="text" name="keyword" value="{{ $keyword }}">
      <input type="submit" value="検索">
    </form>
  
  </div>
  <h2>おすすめユーザー</h2>
  <ul class="recommend_users">
    @forelse($unfollow_users as $unfollow_user)
      <li>
        <a href="{{ route('users.show', $unfollow_user) }}">{{ $unfollow_user->name }}</a>
        @if(Auth::user()->isFollowing($unfollow_user))
          <form method="post" action="{{route('follows.destroy', $unfollow_user)}}" class="follow">
            @csrf
            @method('delete')
            <input type="submit" value="フォロー解除">
          </form>
        @else
          <form method="post" action="{{route('follows.store')}}" class="follow">
            @csrf
            <input type="hidden" name="follow_id" value="{{ $unfollow_user->id }}">
            <input type="submit" value="フォロー">
          </form>
        @endif
      </li>
    @empty
      <li>おすすめユーザーはいません。</li>
    @endforelse
  </ul>
  <h2>タイムライン</h2>
  <ul class="posts_list">
      @forelse($posts as $post)
            <li>
              {{ $post->comment }} 投稿者:<a href="{{ route('users.show', $post->user_id) }}">{{ $post->user->name }}</a> ({{ $post->created_at }})
              @if ($user_id === $post->user_id)
                [<a href="{{ route('posts.edit', $post) }}">編集</a>]
                    <form class="delete" method="post" action="{{ route('posts.destroy', $post) }}">
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="削除">
                    </form>
              @endif
            </li>
      @empty
          <li>投稿がありません。</li>
      @endforelse
  </ul>
  
@endsection