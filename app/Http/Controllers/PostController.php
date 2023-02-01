<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostEditRequest;
use App\User;
use App\Follow;


class PostController extends Controller
{
    public function index(Request $request){
        $user = \Auth::user();
        $user_id = \Auth::id();
        
        $keyword = $request->input('keyword');
        $query = Post::query();
        if(!empty($keyword)) {
            $query->where('comment', 'LIKE', "%{$keyword}%");
            $query->where('user_id' , '!=' , $user_id);
            $posts = $query->latest()->get();
            $follow_user_ids = $user->follow_users->pluck('id');
            $unfollow_users = User::whereNotIn('id' , $follow_user_ids)->where('id' , '!=' , $user->id)->inRandomOrder()->limit(3)->get();
            return view('posts.index', [
                'title' => '投稿一覧', 
                'posts' => $posts,
                'keyword' => $keyword,
                'unfollow_users' => $unfollow_users,
                'user_id' => $user_id,
            ]);
        
        } elseif(empty($keyword)) {
            $follow_user_ids = $user->follow_users->pluck('id');
            $user_posts = $user->posts()->orWhereIn('user_id', $follow_user_ids )->latest()->paginate(5);
            $unfollow_users = User::whereNotIn('id' , $follow_user_ids)->where('id' , '!=' , $user->id)->inRandomOrder()->limit(3)->get();
            return view('posts.index', [
                'title' => '投稿一覧',
                'posts' => $user_posts, 
                'user' => $user,
                'user_id' => $user_id,
                'unfollow_users' => $unfollow_users,
                'keyword' => $keyword,
            ]);
        } 
    }

    public function create()
    {
        return view('posts.create', [
           'title' => '新規投稿', 
        ]);
    }

    public function store(PostRequest $request)
    {
        Post::create([
           'user_id' => \Auth::user()->id,
           'comment' => $request->comment,
        ]);
        \Session::flash('success', '投稿を追加しました');
        return redirect('/posts');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', [
          'title' => '投稿編集',
          'post'  => $post,
        ]);
    }

    public function update(PostEditRequest $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->only(['comment']));
        session()->flash('success', '投稿を編集しました');
        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        
        $post->delete();
        \Session::flash('success', '投稿を削除しました');
        return redirect()->route('posts.index');
    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }

}
