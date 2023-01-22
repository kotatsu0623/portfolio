@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
  <ul>
      @forelse($posts as $post)
            <li>
              {{ $post->comment }} 投稿者:{{ $post->user->name }} ({{ $post->created_at }})
              [<a href="{{ route('posts.edit', $post) }}">編集</a>]
                  <form class="delete" method="post" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除">
                  </form>
            </li>
      @empty
          <li>投稿がありません。</li>
      @endforelse
  </ul>
@endsection