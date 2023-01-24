<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests\PostRequest;
use App\Post;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show($id){
        $user = User::find($id); 
        $posts = Post::where('user_id', $id) 
            ->orderBy('created_at', 'desc') 
            ->paginate(10); 
        $user_id = \Auth::id();

        return view('users.show', [
            'title' => 'ユーザー詳細',
            'user_name' => $user->name, 
            'posts' => $posts, 
            'user' => $user,
            'user_id' => $user_id,

        ]);
    }
    
    
}