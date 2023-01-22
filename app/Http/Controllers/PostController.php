<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostEditRequest;
use App\User;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     // 投稿一覧
    public function index(){
        $posts = \Auth::user()->posts;
        return view('posts.index', [
            'title' => '投稿一覧',
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
           'title' => '新規投稿', 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // 投稿追加処理
    public function store(PostRequest $request)
    {
        
        Post::create([
           'user_id' => \Auth::user()->id,
           'comment' => $request->comment,
        ]);
        \Session::flash('success', '投稿を追加しました');
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('posts.show', [
           'title' => '投稿詳細', 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // 投稿編集フォーム
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', [
          'title' => '投稿編集',
          'post'  => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // 投稿更新処理
    public function update(PostEditRequest $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->only(['comment']));
        session()->flash('success', '投稿を編集しました');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 投稿削除処理
    public function destroy($id)
    {
        $post = Post::find($id);
        
        $post->delete();
        \Session::flash('success', '投稿を削除しました');
        return redirect()->route('posts.index');
    }
    
    public function __construct()
    {
        // auth ミドルウェアを Postコントローラの全てのアクションに登録
        $this->middleware('auth');
    }
    
    public function toggleLike($id){
        $user = \Auth::user();
        $post = Post::find($id);
        
        if($post->isLikedBy($user)){
            // いいねの取り消し
            $post->likes->where('user_id', $user->id)->first()->delete();
            \Session::flash('success', 'いいねを取り消しました');
        } else {
            // いいねを設定
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            \Session::flash('success', 'いいねしました');
        }
        return redirect('/posts');
    }
    
}
