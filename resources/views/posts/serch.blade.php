@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
  <ul>
    
      @forelse($posts as $post)
        
            <li>
              {{ $post->comment }} 投稿者:{{ $post->user->name }} ({{ $post->created_at }})
            </li>
        
      @empty
          <li>投稿がありません。</li>
      @endforelse
    
  </ul>
  
@endsection