@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <p>{{ $user_name }}</p>
    @if($user_id != $user->user_id)
        @if($user_id != $user->id)
            @if(Auth::user()->isFollowing($user))
                <form method="post" action="{{route('follows.destroy', $user)}}" class="follow">
                    @csrf
                    @method('delete')
                    <input type="submit" value="フォロー解除">
                </form>
            @else
                <form method="post" action="{{route('follows.store')}}" class="follow">
                    @csrf
                    <input type="hidden" name="follow_id" value="{{ $user->id }}">
                    <input type="submit" value="フォロー">
                </form>
            @endif
        @endif
    @endif
  <div>
      @forelse($posts as $post)
          </p>{{ $post->comment }} ({{ $post->created_at }})</p>
      @empty
          <p>書き込みはありません。</p>
      @endforelse
  </div>
@endsection