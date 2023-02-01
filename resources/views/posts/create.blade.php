@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <form method="POST" action="{{ route('posts.store') }}">
      @csrf
      <div>
          <label for="comment">
            コメント:<br>
            <textarea name="comment" cols="20" rows="10"></textarea>
          </label>
      </div>
 
      <input type="submit" value="投稿">
  </form>
@endsection