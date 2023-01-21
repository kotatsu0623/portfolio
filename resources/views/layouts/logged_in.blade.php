@extends('layouts.default')
 
@section('header')
<header>
    <h1><a href="{{ route('posts.index') }}">マイクロブログ</a></h1>
    <ul class="header_nav">
        <li>
          <a href="{{ route('posts.create') }}">
            新規投稿
          </a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <input type="submit" value="ログアウト">
            </form>
        </li>
    </ul>
</header>
@endsection